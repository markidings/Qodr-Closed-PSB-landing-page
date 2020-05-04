<?php

namespace App\Services;

class PartnerService
{
    public function saveMetaPhotos($request, $newPartner) {
        $metaNewPartner = [];
        if ($request->hasFile('profile_photo')) { 
            $profilePhotoPath = $newPartner['profile_photo']->store('public/images/partners/profile_photo');
            $metaNewPartner['profile_photo_file'] = $profilePhotoPath;
        }

        if ($request->hasFile('office_photo')) {
            $officePhotoPath = $newPartner['office_photo']->store('public/images/partners/office_photo');
            $metaNewPartner['office_photo_file'] = $officePhotoPath;
        }

        if ($request->hasFile('kitchen_photo')) {
            $kitchenPhotoPath = $newPartner['kitchen_photo']->store('public/images/partners/kitchen_photo');
            $metaNewPartner['kitchen_photo_file'] = $kitchenPhotoPath;
        }

        if ($request->hasFile('shed_photo')) {
            $shedPhotoPath = $newPartner['shed_photo']->store('public/images/partners/shed_photo');
            $metaNewPartner['shed_photo_file'] = $shedPhotoPath;
        }

        return $metaNewPartner;
    }
}
