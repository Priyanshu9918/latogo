<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Auth;
use Akaunting\Money\Money;
use Akaunting\Money\Currency;

class Helper {

    public static function getBanner()
    {
        $data = DB::table('banners')->where('status',1)->first();

        return $data;
    }
    public static function getBannerPoint()
    {
        $data = DB::table('banner_points')->where('status',1)->get();

        return $data;
    }
    public static function getCategoryClass()
    {
        $data = DB::table('category_classes')->where('status',1)->get();

        return $data;
    }
    public static function getResionOfBest()
    {
        $data = DB::table('resion_of_bests')->where('status',1)->get();

        return $data;
    }
    public static function getFaq()
    {
        $data = DB::table('faqs')->where('status',1)->get();

        return $data;
    }
    public static function recentBlog()
    {
        $data = DB::table('blogs')->where('status',1)->take(6)->get();

        return $data;
    }
    public static function getVideo()
    {
        $data = DB::table('videos')->where('status',1)->get();

        return $data;
    }
    public static function getAboutus()
    {
        $data = DB::table('about_us')->where('status',1)->first();

        return $data;
    }
    public static function getWhywe()
    {
        $data = DB::table('why_wes')->where('status',1)->get();

        return $data;
    }
    public static function getHead()
    {
        $data = DB::table('head_instructors')->where('status',1)->get();

        return $data;
    }
    public static function bottom_banner()
    {
        $data = DB::table('bottom_banners')->where('status',1)->orderBy('id', 'desc')->limit(4)->get();

        return $data;
    }

    public static function clients()
    {
        $data = DB::table('clients')->where('status',1)->get();

        return $data;
    }

    public static function testimonial()
    {
        $data = DB::table('testimonials')->where('status',1)->get();

        return $data;
    }

    public static function education_info()
    {
        $data = DB::table('education_infos')->where('status',1)->orderBy('id', 'desc')->limit(3)->get();;

        return $data;
    }
    public static function whatnewpoint()
    {
        $data = DB::table('whatnewpoints')->where('status',1)->get();;

        return $data;
    }

    public static function getwhatnew()
    {
        $data = DB::table('whatnews')->where('status',1)->first();;

        return $data;
    }

    public static function become_an_instructors()
    {
        $data = DB::table('become_an_instructors')->where('status',1)->orderby("title","asc")->get();
        return $data;
    }
    public static function become_an_instructor_videos()
    {
        $data = DB::table('become_an_instructor_videos')->where('status',1)->first();
        return $data;
    }
    public static function getPriceMaster()
    {
        $data = DB::table('price_masters')->where('status',1)->get();

        return $data;
    }
    public static function getPrice()
    {
        $data = DB::table('pricings')->where('status',1)->first();

        return $data;
    }

    public static function class()
    {
        $data = DB::table('trial_classes')->where('status',1)->first();

        return $data;
    }

    public static function contact_titles()
    {
        $data = DB::table('contact_titles')->where('status',1)->get();

        return $data;
    }

    public static function contact_videos()
    {
        $data = DB::table('contact_videos')->where('status',1)->first();
        return $data;
    }

    public static function short_banners()
    {
        $data = DB::table('short_banners')->where('status',1)->first();
        return $data;
    }

    public static function transform_short_banners()
    {
        $data = DB::table('transform_short_banners')->where('status',1)->first();
        return $data;
    }

    public static function getCourseBanner()
    {
        $data = DB::table('courses')->where('status',1)->latest()->first();
        return $data;
    }
    public static function getReview($id)
    {
        $data = DB::table('reviews')->where('teacher_id', $id)->where('status',1)->get();
        return $data;
    }
    public static function getCourseFaq()
    {
        $data = DB::table('course_faqs')->where('status',1)->get();
        return $data;
    }
    public static function getCourseLevel()
    {
        $data = DB::table('course_levels')->where('status',1)->get();
        return $data;
    }
    public static function getCourseLession()
    {
        $data = DB::table('course_lessions')->where('status',1)->get();
        return $data;
    }
    public static function bookclasses()
    {
        $data = DB::table('bookclasses')->where('status',1)->get();
        return $data;
    }

    public static function homebookclasses()
    {
        $data = DB::table('bookclasses')->where('status',1)->where('is_featured',1)->get();
        return $data;
    }

    public static function findTeacherName($id)
    {
        $data = DB::table('users')->where('id', $id)->where('user_type',2)->first();
        return $data;
    }


    public static function findTeacherdetails($id)
    {
        $data = DB::table('teacher_settings')->where('user_id', $id)->first();
        return $data;
    }

    public static function footer()
    {
        $data = DB::table('footer_texts')->where('status',1)->first();
        return $data;
    }
   
    public static function getBlog()
    {
        $data = DB::table('blogs')->where('status',1)->get();

        return $data;
    }
    public static function getSingleProduct($id)
    {
        $single = DB::table('pricings')->where('id',$id)->get();
        return $single;
    }
    public static function getcartList()
    {
        $userId = Auth::user()->id;
        $cartItems =\Cart::session($userId)->getContent();
        return $cartItems;
    }
    public static function getwish($wish)
    {
        $data = DB::table('bookclasses')->where('id',$wish)->first();

        return $data;
    }
    public static function getlatestFaq()
    {
        $data = DB::table('faqs')->where('status',1)->orderBy("id", "DESC")->take(5)->get();

        return $data;
    }
    public static function getReview1()
    {
        $data = DB::table('reviews')->where('status',1)->get();
        return $data;
    }

    public static function studentlogin()
    {
        $data = DB::table('studentlogins')->where('status',1)->first();
        return $data;
    }
    
    public static function msgCount()
    {
        if(Auth::check())
        {
            return DB::table('ch_messages')->where(['to_id'=>Auth::user()->id,'seen'=>0])->count();
        }
        else{
            return 0;
        }
        

    }
    public static function currency($amount)
    {
        $usdMoney = new Money($amount, new Currency('USD'));
        $eurMoney = $usdMoney->convert(new Currency('EUR') ,0.91);
        $convertedAmount = $eurMoney->getAmount();

        return $convertedAmount;
    }
    
}
?>
