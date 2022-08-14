<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactUsRequest;
use App\Models\{Blog,Category,ContactUs,Newsletter,Service,Setting,Skill,User,Resume,Project,Testimonial};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\ContactUsMail;


class HomeController extends Controller
{
    public function index(){
        
        $Settings = Setting::where('status',1)->where('is_public',1)->get()->pluck('value','key')->toArray();
        $user_image_url = (isset($Settings['user_image']) && $Settings['user_image'] != "") ? asset('uploads/'.$Settings['user_image']) : "";
        $logo_image_url = (isset($Settings['logo_image']) && $Settings['logo_image'] != "") ? asset('uploads/'.$Settings['logo_image']) : "";
        unset($Settings['logo_image_url'],$Settings['user_image_url']);
        $data  = $Settings;
        $data['user_image'] = $user_image_url;
        $data['logo_image'] = $logo_image_url;
        return $data;
    }

    public function home(){
        $services = Service::where('status',1)->select('id','title','image','description')->take(3)->get();
        $blogs = Blog::where('status',1)->select('id','title','slug','image_thumbnail')->take(6)->get();
        $testimonialData = Testimonial::where('status',1)->select('id','name','business','image','description')->take(3)->get();
        $Settings = Setting::where('status',1)->where('is_public',1)->get()->pluck('value','key')->toArray();
        $user_image_url = (isset($Settings['user_image']) && $Settings['user_image'] != "") ? asset('uploads/'.$Settings['user_image']) : "";
        $logo_image_url = (isset($Settings['logo_image']) && $Settings['logo_image'] != "") ? asset('uploads/'.$Settings['logo_image']) : "";
        unset($Settings['logo_image_url'],$Settings['user_image_url']);
        $data  = $Settings;
        $data['user_image'] = $user_image_url;
        $data['logo_image'] = $logo_image_url;
        $data['services'] = $services;
        $data['job_sucesss'] = 90;
        $data['ruuning_project'] = 2;
        $data['project_count'] = 15;
        $data['blogs'] = $blogs;
        $data['testimonialData'] = $testimonialData;
        return $data;
    }

    public function about(){
        $Settings = Setting::where('status',1)->where('is_public',1)->get()->pluck('value','key')->toArray();
        $user_image_url = (isset($Settings['user_image']) && $Settings['user_image'] != "") ? asset('uploads/'.$Settings['user_image']) : "";
        unset($Settings['logo_image_url'],$Settings['user_image_url']);
        $skills = Skill::where('status',1)->select('id','title','image','percentage','color')->get();
        $data  = $Settings;
        $data['user_image'] = $user_image_url;
        $data['skills'] = $skills;
        $data['job_sucesss'] = 90;
        $data['ruuning_project'] = 2;
        $data['project_count'] = 15;
        $data['about_line'] = "Hi there, I am Milan. I am designer, artist, cat  <br>lover and I would like to share with you some of <br> my ideas.";
        $data['video_url'] = "https://fontawesome.com/v4/icon/star-half-o";
        $data['about_image'] = asset('uploads/blogs/image_thumbnail/1jK3jcsL4obMnyeInjZAlbbVM5r6TVKnz3v35545.png');
        return $data;
    }

    public function blogs(Request $request){
        $search = isset($request->search) && !empty($request->search) ? $request->search :false;
        $category = isset($request->category) && !empty($request->category) ? $request->category :false;
        $tag = isset($request->tag) && !empty($request->tag) ? $request->tag :false;
        $blogs = Blog::with([
            'user' => function($query){
                $query->select('id','first_name','last_name','user_name');
            },
            'category' => function($query) use($search){
                $query->select('id','name','alias');
            },
            'blogContent' => function($query) use($search){
                $query->select('id','blog_id','meta_description','tags');
            }
        ])
        ->withCount('comments')
        ->where('status',1)
        ->when($tag,function($query) use($tag){
            $query->whereHas('blogContent', function($query) use($tag){
                $query->Where('tags','like','%'.$tag.'%');
            });
        })
        ->when($search,function($query) use($search){
            $query->where('title','like','%'.$search.'%')
            ->orWhere('subtitle','like','%'.$search.'%')
            ->orWhereHas('blogContent', function($query) use($search){
                $query->where('meta_description','like','%'.$search.'%')
                ->orWhere('tags','like','%'.$search.'%');
            })
            ->orWhereHas('category', function($query) use($search){
                $query->where('name','like','%'.$search.'%');
            });
        })
        ->when($category, function($query) use($category){
            $query->where('category_id',$category);
        })
        ->paginate(5);
        return $blogs;
    }
    public function getCategories(Request $request){
        $search = isset($request->search) && !empty($request->search) ? $request->search :false;
        $Categories = Category::where('status',1)->where('name','like','%'.$search.'%')->get()->makeHidden(['updated_at','status']);
        return $Categories;
    }
    public function recentPost(){
        $posts = Blog::where('status',1)
        ->select('id','title','slug','image_thumbnail','created_at')
        ->orderBy('created_at')
        ->take(5)
        ->get();
        return $posts;
    }

    public function blogDetail($slug=""){

        $blog = Blog::with([
            'user' => function($query){
                $query->select('id','first_name','last_name','user_name','image');
            },
            'category' => function($query){
                $query->select('id','name','alias');
            },
            'blogContent' => function($query){
                $query->select('id','blog_id','meta_description','tags','blog_body');
            },
            'comments.user' => function($query){
                $query->select('id','image','first_name','last_name');
            }
        ])
        ->withCount(['likes' => function($query){
            $query->where('status',1);
        }])
        ->where('status',1)
        ->where('slug',$slug)
        ->first();

        if($blog == null){
            return error('Invalid request.');
        }
        $user_id = auth()->user()->id ?? 0;
        $like_status = false;
        if($user_id != 0){
            $like = $blog->likes->where('user_id',$user_id)->where('blog_id',$blog->id)->where('status',1)->count();
            $like_status = ($like > 0) ? true : false;
        }
        $blog->like_status = $like_status;
        return success('Blog get successfully.',$blog);
    }
    

    public function services(){
        $services = Service::where('status',1)->select('id','title','image','description')->take(3)->get();
        $skills = Skill::where('status',1)->select('id','title','image','percentage','color')->get();
        $data['services'] = $services;
        $data['skills'] = $skills;
        return $data;
    }
    public function contact(){
        $Settings = Setting::where('status',1)->where('is_public',1)->get()->pluck('value','key')->toArray();
        $data['address'] = $Settings['address'];
        $data['support_email'] = $Settings['support_email'];
        $data['contact'] = $Settings['contact'];
        return $data;
    }
    public function newsletter(Request $request){
        $email = $request->email;
        $validator = Validator::make($request->only('email'),['email'=>'required|email|max:256']);
        if ($validator->fails())
        {
            return error($validator->errors()->first(),$validator->errors());
        }
        $Newsletter = Newsletter::firstOrCreate(['email' => $email], [ 'status' => 1]);
        return success('Newsletter subscribed successfully.');
    }
    public function contactUs(ContactUsRequest $request){
        $data = $request->validated();
        $contactUs = ContactUs::create($data);
        if($contactUs){
            $admin = User::where('role',1)->first();
            $data['adminName'] = $admin->name;
            \Mail::to($admin->email)->send(new ContactUsMail($data));
        }
        return success('Contact form submited successfully, Admin will connect to you soon.');
    }
    public function resumeData(){
        $data = Resume::get();
        return success('Resume get successfully.',$data);
    }
    public function testimonial(){
        $testimonialData = Testimonial::where('status',1)->select('id','name','business','image','description')->take(3)->get();
        return success('Testimonial get successfully.',$testimonialData);
    }
    public function downloadCv(){
        $pdf = Resume::where('type','resume_file')->first();
        $file = public_path('uploads/'.$pdf->getAttributes()['data']);
        $headers = ['Content-Type: application/pdf'];
        return \Response::download($file, 'resume.pdf', $headers);
    }
    public function projects(){
        $testimonialData = Project::where('status',Project::STATUSCOMPLATED)
        ->with(['category' => function($query){
            $query->select('id','name');
        }])
        ->select('id','title','slug','image','description','category_id')
        ->when((request()->has('recent') && request()->recent == true), function($query){
            $query->take(5);
        })
        ->get();
        return success('Project get successfully.',$testimonialData);
    }
    public function portfolioDetail($slug=""){

        $project = Project::with([
            'category' => function($query){
                $query->select('id','name','alias');
            },
        ])
        ->where('status',Project::STATUSCOMPLATED)
        ->where('slug',$slug)
        ->first();
        if($project == null){
            return error('Invalid request.');
        }
        return success('Project get successfully.',$project);
    }
   
}
