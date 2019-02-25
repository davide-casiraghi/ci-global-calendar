<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonationOffer extends Model
{
    protected $fillable = [
        'name', 'surname', 'email', 'country_id', 'contact_trough_voip', 'language_spoken', 'offer_kind', 'gift_kind', 'gift_description', 'volunteer_kind', 'volunteer_description', 'other_description', 'suggestions', 'status'
    ];
    
    /***************************************************************************/
    /**
     * Return the donation kind string
     *
     * @param  int $offer_kind
     * @return string $ret  - the donation kind string
     */
     public static function getDonationKindString($offer_kind){
         switch ($offer_kind) {
             case 1:
                 $ret = __('views.donation_kind_financial');
                 break;
             case 2:
                 $ret = __('views.donation_kind_gift');
                 break;
             case 3:
                 $ret = __('views.donation_kind_volunteer');
                 break;
             case 4:
                 $ret = __('views.donation_kind_other');
                 break;
             default:
                $ret = "";
                break;
         }
         return $ret;
     }
     
     /***************************************************************************/
     /**
      * Return the donation kind badge
      *
      * @param  int $offer_kind
      * @return string $ret  - the donation kind string
      */
      public static function getDonationStatusBadge($status){
          switch ($offer_kind) {
              case 1:
                  $ret = "<span class='badge badge-success float-right'>".__('views.donation_status_available')."</span>";
                  break;
              case 2:
                  $ret = "<span class='badge badge-warning float-right'>".__('views.donation_status_expired')."</span>";
                  break;
              case 3:
                  $ret = "<span class='badge badge-secondary float-right'>".__('views.donation_status_used')."</span>";
                  break;
              default:
                 $ret = "";
                 break;
          }
          return $ret;
      }
     
     
}
