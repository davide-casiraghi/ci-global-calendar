<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use App\DonationOffer;
use Illuminate\Http\Request;
use DavideCasiraghi\LaravelEventsCalendar\Models\Country;

class DonationOfferController extends Controller
{
    /* Restrict the access to this resource just to logged in users except show and index view */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['create', 'store', 'index', 'show']]);
    }

    /***************************************************************************/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request);
        //dd($request->ww);
        $countries = Country::getCountries();
        $searchKeywords = $request->input('keywords');
        $searchCountry = $request->input('country_id');

        if ($searchKeywords || $searchCountry) {
            $donationOffers = DonationOffer::
                when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('name', $searchKeywords)->orWhere('name', 'like', '%'.$searchKeywords.'%');
                })
                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('surname', $searchKeywords)->orWhere('surname', 'like', '%'.$searchKeywords.'%');
                })
                ->when($searchCountry, function ($query, $searchCountry) {
                    return $query->where('country_id', '=', $searchCountry);
                })
                ->orderBy('name')
                ->paginate(20);
        } else {
            $donationOffers = DonationOffer::
                orderBy('name')
                ->paginate(20);
        }

        return view('donationOffers.index', compact('donationOffers'))
            ->with('i', (request()->input('page', 1) - 1) * 20)
            ->with('page_kind', $request->page_kind)
            ->with('countries', $countries)
            ->with('searchKeywords', $searchKeywords)
            ->with('searchCountry', $searchCountry);
    }

    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$authorUserId = $this->getLoggedAuthorId();
        $users = User::pluck('name', 'id');
        $countries = Country::getCountries();

        return view('donationOffers.create')
                ->with('countries', $countries)
                ->with('users', $users);
        //->with('authorUserId',$authorUserId);
    }

    /***************************************************************************/

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
                'name' => 'required',
                'surname' => 'required',
                'email' => 'required',
                'country_id' => 'required',
            ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $donationOffer = new DonationOffer();

        $this->saveOnDb($request, $donationOffer);

        return redirect()->route('home')->with('message', __('donations.thank_you').' '.__('donations.thank_you_desc'));
    }

    /***************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  \App\DonationOffer  $donationOffer
     * @return \Illuminate\Http\Response
     */
    public function show(DonationOffer $donationOffer)
    {
        $country = Country::
                        select('id', 'name', 'continent_id')
                        ->where('id', $donationOffer->country_id)
                        ->first();

        return view('donationOffers.show', compact('donationOffer'))->with('country', $country);
    }

    /***************************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DonationOffer  $donationOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(DonationOffer $donationOffer)
    {
        $countries = Country::getCountries();

        $giftGivenWhenDate = date('d/m/Y', strtotime($donationOffer->gift_given_when));

        return view('donationOffers.edit', compact('donationOffer'))
            ->with('countries', $countries)
            ->with('giftGivenWhenDate', $giftGivenWhenDate);
    }

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DonationOffer  $donationOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DonationOffer $donationOffer)
    {
        request()->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'country_id' => 'required',
        ]);

        $this->saveOnDb($request, $donationOffer);

        return redirect()->route('donationOffers.index', ['page_kind' => $donationOffer->offer_kind])
                        ->with('success', __('messages.donation_offer_updated_successfully'));
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DonationOffer  $donationOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(DonationOffer $donationOffer)
    {
        $donationOffer->delete();

        return redirect()->route('donationOffers.index', ['page_kind' => $donationOffer->offer_kind])
                        ->with('success', __('messages.donation_offer_deleted_successfully'));
    }

    /***************************************************************************/

    /**
     * Save the record on DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DonationOffer  $donationOffer
     * @return \Illuminate\Http\Response
     */
    public function saveOnDb($request, $donationOffer)
    {
        $donationOffer->name = $request->get('name');
        $donationOffer->surname = $request->get('surname');
        $donationOffer->email = $request->get('email');
        $donationOffer->country_id = $request->get('country_id');
        $donationOffer->contact_trough_voip = strip_tags($request->get('contact_trough_voip'));
        $donationOffer->language_spoken = strip_tags($request->get('language_spoken'));
        $donationOffer->offer_kind = $request->get('offer_kind');
        $donationOffer->gift_kind = $request->get('gift_kind');
        $donationOffer->gift_description = clean($request->get('gift_description'));
        $donationOffer->volunteer_kind = $request->get('volunteer_kind');
        $donationOffer->volunteer_description = clean($request->get('volunteer_description'));
        $donationOffer->other_description = $request->get('other_description');
        $donationOffer->suggestions = $request->get('suggestions');
        $donationOffer->status = $request->get('status');
        $donationOffer->gift_donater = $request->get('gift_donater');
        $donationOffer->gift_economic_value = $request->get('gift_economic_value');
        $donationOffer->gift_volunteer_time_value = $request->get('gift_volunteer_time_value');
        $donationOffer->gift_given_to = $request->get('gift_given_to');
        $donationOffer->gift_given_when = implode('-', array_reverse(explode('/', $request->get('gift_given_when'))));
        $donationOffer->gift_country_of = $request->get('gift_country_of');
        $donationOffer->admin_notes = $request->get('admin_notes');
        $donationOffer->gift_title = $request->get('gift_title');

        //dd($donationOffer);

        $donationOffer->save();
    }

    /***************************************************************************/

    /*
     * Display a listing of the resource - the public list.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function indexPublic(Request $request)
    {
        $countries = Country::getCountries();

        $donationKindArray = [];
        foreach (DonationOffer::getDonationKindArray() as $key => $value) {
            $donationKindArray[$key] = $value['label'];
        }

        $searchKeywords = $request->input('keywords');
        $searchCountry = $request->input('country_id');
        $searchDonationKind = $request->input('donation_kind_filter');

        // Show just to the owner - Get created_by value if the user is not an admin or super admin
        // $loggedUser = $this->getLoggedAuthorId();

        if ($searchKeywords || $searchCountry || $searchDonationKind) {
            $donationOffers = DonationOffer::
                where('offer_kind', '2')
                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('name', $searchKeywords)->orWhere('name', 'like', '%'.$searchKeywords.'%');
                })
                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('surname', $searchKeywords)->orWhere('surname', 'like', '%'.$searchKeywords.'%');
                })
                ->when($searchCountry, function ($query, $searchCountry) {
                    return $query->where('country_id', '=', $searchCountry);
                })
                ->when($searchDonationKind, function ($query, $searchDonationKind) {
                    return $query->where('offer_kind', '=', $searchDonationKind);
                })
                ->orderBy('name')
                ->paginate(20);
        } else {
            $donationOffers = DonationOffer::
                where('offer_kind', '2')
                ->orderBy('name')
                ->paginate(20);
        }

        //dd($donationOffers);
        return view('donationOffers.indexPublic', compact('donationOffers'))
                    ->with('i', (request()->input('page', 1) - 1) * 20)
                    ->with('countries', $countries)
                    ->with('donationKindArray', $donationKindArray)
                    ->with('searchKeywords', $searchKeywords)
                    ->with('searchCountry', $searchCountry)
                    ->with('searchDonationKind', $searchDonationKind);
    }
*/
    /***************************************************************************/
}
