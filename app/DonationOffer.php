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
                 $ret = __('donations.donation_kind_financial');
                 break;
             case 2:
                 $ret = __('donations.donation_kind_gift');
                 break;
             case 3:
                 $ret = __('donations.donation_kind_volunteer');
                 break;
             case 4:
                 $ret = __('donations.donation_kind_other');
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
      * @return string $ret  - the status badge HTML
      */
      public static function getDonationStatusBadge($status){
          switch ($status) {
              case 1:
                  $ret = "<span class='badge badge-success float-right'>".__('donations.status_available')."</span>";
                  break;
              case 2:
                  $ret = "<span class='badge badge-warning float-right'>".__('donations.status_expired')."</span>";
                  break;
              case 3:
                  $ret = "<span class='badge badge-secondary float-right'>".__('donations.status_used')."</span>";
                  break;
              default:
                 $ret = "";
                 break;
          }
          return $ret;
      }
      
      /***************************************************************************/
      /**
       * Return the donation status array
       *
       * @param  int $offer_kind
       * @return array $ret  - the status array
       */
       public static function getStatusArray(){
           $ret = [
                1 => __('donations.status_available'),
                2 => __('donations.status_expired'),
                3 => __('donations.status_used'),
            ];
           
           return $ret;
       }
     
       /***************************************************************************/
       /**
        * Return the gift kind array
        *
        * @param  int $offer_kind
        * @return array $ret  - the gift kind array
        */
        public static function getGiftKindArray(){
            $ret = [
                 1 => __('donations.gift_kind_free_festival'),
                 2 => __('donations.gift_kind_free_other'),
                 3 => __('donations.gift_kind_fee'),
             ];
            
            return $ret;
        }
        
        /***************************************************************************/
        /**
         * Return the volunteering kind array
         *
         * @param  int $offer_kind
         * @return array $ret  - the volunteering kind array
         */
         public static function getVolunteeringKindArray(){
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
          * Return the volunteering kind array
          *
          * @param  int $offer_kind
          * @return array $ret  - the volunteering kind array
          */
          public static function getVolunteeringKindDescriptionsArray(){
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
