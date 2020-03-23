<?php

namespace App\Http\Controllers;

use App\Exports\subscribersExport;
use App\NewsletterSubscriber;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class NewsletterController extends Controller
{
    public function checkSubscriber(Request $request)
    {
        // This is ajax request then into VerifyCsrfToken->except (The URIs that should be excluded from CSRF verification.)
        if($request->ajax()) {
            $data = $request->all();
            $subscriberCount = NewsletterSubscriber::where(['email'=>$data['subscriber_email']])->count();
            if($subscriberCount>0) {
                echo "exists";die;
            }
        }
    }
    public function addSubscriber(Request $request)
    {
        // This is ajax request then into VerifyCsrfToken->except (The URIs that should be excluded from CSRF verification.)
        if($request->ajax()) {
            $data = $request->all();
            $subscriberCount = NewsletterSubscriber::where(['email'=>$data['subscriber_email']])->count();
            if($subscriberCount>0) {
                echo "exists";die;
            } else {
                //Add Newsletter Email in newsletter_subscribers table
                $newletter = new NewsletterSubscriber;
                $newletter->email = $data['subscriber_email'];
                $newletter->save();
                echo "saved";
            }
        }
    }

    public function viewSubscriber() {
        $newsletters = NewsletterSubscriber::get();
        return view('admin.newsletters.view_newsletters')->with(compact('newsletters'));
    }

    public function editSubscriber(Request $request,$id){
		if($request->isMethod('post')){
			$data = $request->all();
			/*echo "<pre>"; print_r($data); die;*/
			NewsletterSubscriber::where('id',$id)->update([]);
			return redirect()->back()->with('flash_message_success','Newsletter Subscriber updated Successfully!');
		}
		$newsletterDetails = NewsletterSubscriber::where('id',$id)->first();
		return view('admin.newsletters.edit_newsletters')->with(compact('newsletterDetails'));
    }

    public function deleteSubscriber($id){
        NewsletterSubscriber::where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success','Newsletter Email has been deleted successfully!');
	}
    
    public function editStatus($id,$status){
        NewsletterSubscriber::where('id',$id)->update(['status'=>$status]);
        return redirect()->back()->with('flash_message_success','Status Newsletter updated Successfully!');
    }

    // if laravel version ^5
    // public function exportSubscriber() {
    //     $subscribersData = NewsletterSubscriber::select("id","email","created_at")->where('status',1)->orderBy("id","desc")->get()->toArray();

    //     return Excel::create('subscribers'.rand(), function($excel) use($subscribersData) {
    //         $excel->sheet('mySheet', function($sheet) use($subscribersData) {
    //             $sheet->fromArray($subscribersData);
    //         });
    //     })->download('xlsx'); 
    // }
    // if laravel version ^6
    public function exportSubscriber() {
        // php artisan make:export subscribersExport --model=NewsletterSubscriber
        return Excel::download(new subscribersExport, 'subscribers.xlsx');
    }

    
}
