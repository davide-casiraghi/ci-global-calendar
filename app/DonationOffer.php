<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonationOffer extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'donation_offers';

    /***************************************************************************/

    protected $fillable = [
        'name', 'surname', 'email', 'country_id', 'contact_trough_voip',
        'language_spoken', 'offer_kind', 'gift_kind', 'gift_description', 
        'volunteer_kind', 'volunteer_description', 'other_description', 
        'suggestions', 'status','gift_donater','gift_economic_value',
        'gift_volunteer_time_value','gift_given_to','gift_given_when',
        'gift_country_of','admin_notes','gift_title',
    ];

    /***************************************************************************/

    /**
     * Return the donation kind array.
     *
     * @param  int $offer_kind
     * @return array
     */
    public static function getDonationKindArray()
    {
        $ret = [
              1 =>[
                  'label'=> __('donations.donation_kind_financial'),
                  'icon'=> 'far fa-hand-holding-usd',
                  'id' => 'offerFinancial',
              ],
              2 =>[
                  'label'=> __('donations.donation_kind_free_entrance'),
                  'icon'=> 'far fa-ticket-alt',
                  'id' => 'offerFreeEntrance',
              ],
              3 =>[
                  'label'=> __('donations.donation_kind_volunteer'),
                  'icon'=> 'far fa-hands-helping',
                  'id' => 'offerVolunteer',
              ],
              4 =>[
                  'label'=> __('donations.donation_kind_other_gift'),
                  'icon'=> 'far fa-gift',
                  'id' => 'offerOtherGift',
              ],
          ];

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return the donation kind badge HTML.
     *
     * @param  int $status
     * @return string
     */
    public static function getDonationStatusBadge($status)
    {
        switch ($status) {
              case 1:
                  $ret = "<span class='badge badge-success float-right'>".__('donations.status_available').'</span>';
                  break;
              case 2:
                  $ret = "<span class='badge badge-warning float-right'>".__('donations.status_expired').'</span>';
                  break;
              case 3:
                  $ret = "<span class='badge badge-secondary float-right'>".__('donations.status_used').'</span>';
                  break;
              case 4:
                  $ret = "<span class='badge badge-danger float-right'>".__('donations.status_refused').'</span>';
                  break;
              default:
                 $ret = '';
                 break;
          }

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return the donation status array.
     *
     * @return array
     */
    public static function getStatusArray()
    {
        $ret = [
                1 => __('donations.status_available'),
                2 => __('donations.status_expired'),
                3 => __('donations.status_used'),
                4 => __('donations.status_refused'),
            ];

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return the gift kind array.
     *
     * @return array
     */
    public static function getGiftKindArray()
    {
        $ret = [
                 1 => __('donations.gift_kind_free_festival'),
                 2 => __('donations.gift_kind_free_other'),
             ];

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return the volunteering kind array.
     *
     * @return array
     */
    public static function getVolunteeringKindArray()
    {
        $ret = [
                  1 => __('donations.volunteering_kind_developer'),
                  2 => __('donations.volunteering_kind_fundriser'),
                  3 => __('donations.volunteering_kind_translator'),
                  4 => __('donations.volunteering_kind_communicator'),
                  5 => __('donations.volunteering_kind_other'),
              ];

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return the volunteering kind array.
     *
     * @return array
     */
    public static function getVolunteeringKindDescriptionsArray()
    {
        $ret = [
                   1 => __('donations.volunteering_kind_developers'),
                   2 => __('donations.volunteering_kind_fundrisers'),
                   3 => __('donations.volunteering_kind_translators'),
                   4 => __('donations.volunteering_kind_communicators'),
                   5 => __('donations.volunteering_kind_others'),
               ];

        return $ret;
    }
}
