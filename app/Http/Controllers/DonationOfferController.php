<?php

namespace App\Http\Controllers;

use App\DonationOffer;
use App\Country;
use App\User;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class DonationOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $minutes = 15;    
        $countries = Cache::remember('countries', $minutes, function () {
            return Country::orderBy('name')->pluck('name', 'id');
        });
        
        $searchKeywords = $request->input('keywords');
        $searchCountry = $request->input('country_id');

        // Show just to the owner - Get created_by value if the user is not an admin or super admin
        $loggedUser = $this->getLoggedAuthorId();
        
        if ($searchKeywords||$searchCountry){
            $donationOffers = DB::table('event_venues')
                ->when($loggedUser->id, function ($query, $loggedUserId) {
                    return $query->where('created_by', $loggedUserId);
                })
                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('name', $searchKeywords)->orWhere('name', 'like', '%' . $searchKeywords . '%');
                })
                ->when($searchCountry, function ($query, $searchCountry) {
                    return $query->where('country_id', '=', $searchCountry);
                })
                ->orderBy('name')
                ->paginate(20);
        }
        else
            $donationOffers = DonationOffer::
                when($loggedUser->id, function ($query, $loggedUserId) {
                    return $query->where('created_by', $loggedUserId);
                })
                ->orderBy('name')
                ->paginate(20);

        return view('donationOffers.index',compact('donationOffers'))
                    ->with('i', (request()->input('page', 1) - 1) * 20)
                    ->with('countries', $countries)
                    ->with('searchKeywords',$searchKeywords)
                    ->with('searchCountry',$searchCountry);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $authorUserId = $this->getLoggedAuthorId();
        $users = User::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');

        return view('donationOffers.create')
                ->with('countries', $countries)
                ->with('users', $users)
                ->with('authorUserId',$authorUserId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate form datas
            $validator = Validator::make($request->all(), [
                'name' => 'required'
                'surname' => 'required'
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
        
        $donationOffer = new DonationOffer();

        $this->saveOnDb($request, $donationOffer);

        return redirect()->route('donationOffers.index')
                        ->with('success',__('messages.donation_offer_added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DonationOffer  $donationOffer
     * @return \Illuminate\Http\Response
     */
    public function show(DonationOffer $donationOffer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DonationOffer  $donationOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(DonationOffer $donationOffer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DonationOffer  $donationOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DonationOffer $donationOffer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DonationOffer  $donationOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(DonationOffer $donationOffer)
    {
        //
    }
    
    
    /***************************************************************************/
    /**
     * Save the record on DB
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
     public function saveOnDb($request, $donationOffer){
         $donationOffer->name = $request->get('name');
         $donationOffer->surname = $request->get('surname');
         $donationOffer->email = $request->get('email');
         $donationOffer->country_id = $request->get('country_id');
         $donationOffer->contact_trough_voip = clean($request->get('contact_trough_voip'));
         $donationOffer->language_spoken = clean($request->get('language_spoken'));
         $donationOffer->offer_kind = $request->get('offer_kind');
         $donationOffer->gift_kind = $request->get('gift_kind');
         $donationOffer->gift_description = $request->get('gift_description');
         $donationOffer->volunteer_kind = $request->get('volunteer_kind');
         $donationOffer->volunteer_description = $request->get('volunteer_description');
         $donationOffer->other_description = $request->get('other_description');
         $donationOffer->suggestions = $request->get('suggestions');
         $donationOffer->status = $request->get('status');
         
         $donationOffer->save();
     }
}
