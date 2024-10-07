<?php

use App\Models\Branch;
use App\Models\Setting;
use App\Models\MemberComp;
use App\Models\MemberUserProfile;
use App\Models\Member;
use App\Models\State;
use App\Models\Country;
use App\Models\Gender;
use App\Models\InvoiceRunningNo;
use App\Models\PlanTier;
use App\Models\LogSystem;
use App\Models\Salutation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

if (!function_exists('pr')) {
    function pr($data)
    {
        echo "<pre>";
        print_r($data);
        exit();
    }
}

function addPageJsLink($link)
{
    return asset('backend/assets/js/pages') . "/" . $link . '?' . time();
}
function getLogoPath()
{
    $setting = Setting::where('name', 'logo')->first();
    $logoPath = 'storage/backend/assets/img/logo/' . ($setting->value ?? '');

    if ($setting && file_exists(public_path($logoPath))) {
        return asset($logoPath);
    } else {
        return asset('frontend/img/logo/email-rehda-logo-blue.png'); // Path to default logo
    }
}

if (!function_exists('getMCStatus')) {
    function getMCStatus($statusid)
    {
        $stringStatus = "";

        if ($statusid == 1) {
            $stringStatus = '<span class="badge bg-success lb-lg">Active</span>';
        } elseif ($statusid == 2) {
            $stringStatus = '<span class="badge bg-info lb-lg">Pending</span>';
        } elseif ($statusid == 3) {
            $stringStatus = '<span class="badge bg-danger lb-lg">Reject</span>';
        } else {
            $stringStatus = '<span class="badge bg-primary lb-lg">Inactive</span>';
        }

        return $stringStatus;
    }
}

if (!function_exists('getMCStatusCSV')) {
    function getMCStatusCSV($statusid)
    {
        $stringStatus = "";

        if ($statusid == 1) {
            $stringStatus = 'Active';
        } elseif ($statusid == 2) {
            $stringStatus = 'Pending';
        } elseif ($statusid == 3) {
            $stringStatus = 'Reject';
        } else {
            $stringStatus = 'Inactive';
        }

        return $stringStatus;
    }
}

if (!function_exists('getMembershipNobyMID')) {
    function getMembershipNobyMID($mid)
    {
        // Fetch the MemberComp related to the given MID
        $memberComp = MemberComp::where('d_mid', $mid)->with('member')->first();

        if (!$memberComp) {
            return null; // Or handle the case where the member is not found
        }

        // If m_type is not 6, construct the membership number
        if ($memberComp->member->m_type != 6) {
            $mno = $memberComp->member->m_no_p1 .
                $memberComp->member->m_no_p2 .
                $memberComp->member->m_no_p3 .
                $memberComp->member->m_no_p4 .
                config('constant.MNP2') .
                $memberComp->member->m_no_p5;
        } else {
            // If m_type is 6, get the membership number from member_userprofiles
            $userProfile = MemberUserProfile::where('up_mid', $memberComp->did)->first();

            if ($userProfile) {
                $mno = $userProfile->up_mykad;
            } else {
                $mno = null; // Or handle the case where the profile is not found
            }
        }

        return $mno;
    }
}

if (!function_exists('getStatex')) {
    function getStatex($stateId)
    {
        // Fetch the state from the database using Eloquent
        $state = State::find($stateId);

        // If state is found, return the state name, otherwise return null or handle the case accordingly
        return $state ? $state->state_name : null;
    }
}

if (!function_exists('getCountryx')) {
    function getCountryx($cid)
    {
        // Fetch the country from the database using Eloquent
        $country = Country::find($cid);

        // If the country is found, return the country name, otherwise return null or handle the case accordingly
        return $country ? $country->country_name : null;
    }
}

if (!function_exists('getCapital')) {
    function getCapital($cid)
    {
        // Fetch the plan tier from the database using Eloquent
        $planTier = PlanTier::find($cid);

        // If the plan tier is found, return the description, otherwise return null or handle the case accordingly
        return $planTier ? $planTier->pt_desc : null;
    }
}

if (!function_exists('logSystem')) {
    function logSystem($uid, $activity, $msg, $module)
    {
        LogSystem::create([
            'user_id' => $uid,
            'activity' => $activity,
            'record' => is_array($msg) ? json_encode($msg) : $msg,
            'page' => $module,
            'datetime' => now()
        ]);
    }
}

if (!function_exists('getLatestMainRunningNo')) {
    function getLatestMainRunningNo($mid)
    {
        // Get the current timestamp
        $today = Carbon::now();

        // Get the maximum value of `m_no_p2` from the `members` table
        $maxNo = Member::max('m_no_p2');

        // Increment the maximum number and pad with zeroes
        $run = str_pad($maxNo + 1, 4, "0", STR_PAD_LEFT);

        return $run;
    }
}

if (!function_exists('chkMembershipNoExisted')) {
    function chkMembershipNoExisted($p1, $p2, $p3, $p4, $p5)
    {
        // Query to check if a member exists with the given parameters
        $count = Member::where('m_no_p1', $p1)
            ->where('m_no_p2', $p2)
            ->where('m_no_p3', $p3)
            ->where('m_no_p4', $p4)
            ->where('m_no_p5', $p5)
            ->count();

        return $count;
    }
}

if (!function_exists('getMembershipNo')) {
    function getMembershipNo($mid)
    {
        // First, fetch the member from the 'members' table
        $member = Member::find($mid);

        if (!$member) {
            return null; // If no member is found, return null or handle as required
        }

        // If the member type is not 6, concatenate the membership number parts
        if ($member->m_type != 6) {
            $mno = $member->m_no_p1 . $member->m_no_p2 . $member->m_no_p3 . $member->m_no_p4 . config('constant.MNP2') . $member->m_no_p5;
        } else {
            // If member type is 6, fetch data from 'member_userprofiles' and 'member_comps' tables
            $userProfile = MemberUserProfile::whereHas('memberComp', function ($query) use ($mid) {
                $query->where('d_mid', $mid);
            })->first();

            if (!$userProfile) {
                return null; // If no user profile is found, return null or handle as needed
            }

            // Use 'up_mykad' for member number
            $mno = $userProfile->up_mykad;
        }

        return $mno;
    }
}

if (!function_exists('getMemberUserTypePriv')) {
    function getMemberUserTypePriv($typeid)
    {
        if ($typeid == 1) {
            return "OfficeRep";
        } else {
            return "CompanyAdmin";
        }
    }
}

if (!function_exists('getMemberUserType')) {
    function getMemberUserType($typeid)
    {
        if ($typeid == 1) {
            return "OfficeRep";
        } else {
            return "CompanyAdmin";
        }
    }
}

if (!function_exists('getTitle')) {
    function getTitle($sid)
    {
        $salutation = Salutation::find($sid);
        if($salutation){
            return $salutation->sname;
        }
        return '';
    }
}

if (!function_exists('getGender')) {
    function getGender($gid)
    {
        $gender = Gender::find($gid);
        if($gender){
            return $gender->gname;
        }
        return '';
    }
}

if (!function_exists('getMMStatus')) {
    function getMMStatus($statusid)
    {
        $stringStatus = "";

        if ($statusid == 1) {
            $stringStatus =  '<span class="badge bg-success">Active</span>';
        } else if ($statusid == 2) {
            $stringStatus =  '<span class="badge bg-info">Inactive</span>';
        }

        return $stringStatus;
    }
}

if (!function_exists('getMMStatusCSV')) {
    function getMMStatusCSV($statusid)
    {
        $stringStatus = "";

        if ($statusid == 1) {
            $stringStatus =  'Active';
        } else if ($statusid == 2) {
            $stringStatus =  'Inactive';
        }

        return $stringStatus;
    }
}

if (!function_exists('getChangeRequestStatusCSV')) {
    function getChangeRequestStatusCSV($statusid)
    {
        $stringStatus = "";

        if ($statusid == 1) {
            $stringStatus =  'New';
        } else if ($statusid == 2) {
            $stringStatus =  'Completed';
        } else {
            $stringStatus =  'Rejected';
        }

        return $stringStatus;
    }
}



if (!function_exists('getMemberCompanyName')) {
    function getMemberCompanyName($mid)
    {
        // Find the member company by the 'did' field (which corresponds to the $mid)
        $company = MemberComp::find($mid);

        // Check if the company was found
        if ($company) {
            // Return the 'd_compname' field (company name)
            return $company->d_compname;
        }

        // Return null if no company was found for the given MID
        return null;
    }
}

if (!function_exists('getWebUrl')) {
    function getWebUrl($url)
    {
        if ($url && !preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }

        return $url;
    }
}

if (!function_exists('membershipActivateEmailTemp')) {
    function membershipActivateEmailTemp($fname, $uname, $pws, $compname)
    {
        return view('emails.membership_activated', compact('fname', 'uname', 'pws', 'compname'))->render();
    }
}

if (!function_exists('chkAdminAccess')) {
    function chkAdminAccess()
    {
        // Define the roles that have admin access
        $adminRoles = [
            'SuperAdmin',
            'HQAdmin',
            'HQFinanceAdmin',
            'MembershipAdmin',
            'Developer',
            'MediaAdmin'
        ];

        // Check if the authenticated user has any of the roles
        if (Auth::user()->hasAnyRole($adminRoles)) {
            return 1; // Admin access granted
        }

        return 2; // No admin access
    }
}

if (!function_exists('getMemberToSendInv')) {
    function getMemberToSendInv($mid)
    {
        // Query for the user with up_usertype=2
        $userProfile = MemberUserProfile::where('up_mid', $mid)
            ->where('up_usertype', 2)
            ->orderBy('up_id', 'asc')
            ->first();

        // If no user with up_usertype=2, query for up_usertype=1
        if (!$userProfile) {
            $userProfile = MemberUserProfile::where('up_mid', $mid)
                ->where('up_usertype', 1)
                ->orderBy('up_id', 'asc')
                ->first();
        }

        // If user profile exists, return the required fields
        if ($userProfile) {
            return [
                'fullname' => $userProfile->up_fullname,
                'email'    => $userProfile->up_emailadd,
                'title'    => getTitle($userProfile->up_title),
                'hp'       => $userProfile->up_contactno
            ];
        }

        return null; // Return null if no matching user profile is found
    }
}

if (!function_exists('chkV')) {
    function chkV($referer)
    {
        // Retrieve allowed domains from .env or config
        $allowed_host = config('constant.MAINDOMAIN');
        $allowedwww = config('constant.MAINDOMAINWWW');

        // Parse URL components
        $scheme = parse_url($referer, PHP_URL_SCHEME);
        $host = parse_url($referer, PHP_URL_HOST);

        // Construct the full URL
        $url = $scheme . "://" . $host . "/";

        // Log the details for debugging
        Log::info('Referer URL: ' . $url);
        Log::info('Allowed Host: ' . $allowed_host);

        // Check if referer matches the allowed domains
        if ($url === $allowed_host || $url === $allowedwww) {
            return true;
        } else {
            return false;
        }
    }
}



// ======================= ################ ======================== //
if (!function_exists('getCoverImagePath')) {
    function getCoverImagePath()
    {
        $setting = Setting::where('name', 'login_cover_image')->first();
        if (!empty($setting) && $setting->value) {
            return asset('storage/backend/assets/img/login-cover-image') . "/" . $setting->value;
        }
        return asset('backend/assets/img/illustrations/girl-verify-password-light.png');
    }
}

if (!function_exists('getBackgroundStyle')) {
    function getBackgroundStyle()
    {
        $settings = Setting::whereIn('name', ['background_type', 'login_background_image', 'background_color'])->get()->keyBy('name');

        $backgroundType = $settings->get('background_type');
        if ($backgroundType) {
            if ($backgroundType->value == 1) {
                $backgroundImage = $settings->get('login_background_image');
                if ($backgroundImage) {
                    return 'background-image: url("' . asset('storage/backend/assets/img/login-background-image/' . $backgroundImage->value) . '");';
                }
            } elseif ($backgroundType->value == 0) {
                $backgroundColor = $settings->get('background_color');
                if ($backgroundColor) {
                    return 'background-color: ' . $backgroundColor->value;
                }
            }
        }
        return '';
    }
}
function getFavicon()
{
    $setting = Setting::where('name', 'favicon')->first();
    return asset('storage/backend/assets/img/favicon') . "/" . $setting->value;
}
function getSetting($key)
{
    $setting = Setting::pluck('value', 'name')->toArray();
    if (!empty($setting)) {
        if ($key == 'order_desk_title') {
            $hour = now()->hour;
            $greeting = 'night';

            if ($hour >= 5 && $hour < 12) {
                $greeting = 'morning';
            } elseif ($hour >= 12 && $hour < 17) {
                $greeting = 'afternoon';
            } elseif ($hour >= 17 && $hour < 21) {
                $greeting = 'evening';
            }
            return str_replace("xxxx {name}", $greeting . " User", $setting[$key]);
        }
        return $setting[$key];
    }
    return null;
}

function assetVersion()
{
    return '1001';
}

if (!function_exists('cacheclear')) {
    function cacheclear()
    {
        return time();
    }
}


function getMembershipNo($mid)
{
    $member = Member::where('mid', $mid)->first();
    if($member->m_type != 6) {
        $mno = $member->m_no_p1 . $member->m_no_p2 . $member->m_no_p3 . $member->m_no_p4 . config('constant.MNP2') .$member->m_no_p5;
    } else {
        $memberProfile = MemberUserProfile::join('member_comps', 'member_userprofiles.up_mid', '=', 'member_comps.did')->where('member_comps.d_mid', $mid)->select('member_userprofiles.*', 'member_comps.*')->first();
        $mno = $memberProfile->up_mykad;
    }
    return $mno;
}

function getMemberType($mid)
{
    $member = Member::join('member_comps', 'member_comps.d_mid', '=', 'members.mid')
    ->where('member_comps.did', $mid)
    ->select('members.*')
    ->first();

    return $member->m_type;
}

function getMemberDid($mid)
{
    $memberComp = MemberComp::where('did', $mid)->first();
    return $memberComp->d_mid;
}

function getChildMid($pmid)
{
    $mid = getMemberDid($pmid);
    $memberComparray = MemberComp::where('d_parentcomp', $mid)->pluck('did')->toArray();
    return $memberComparray;
}

function getMMRegDate($mid)
{
    $memberComp = MemberComp::where('did', $mid)->first();
    return $memberComp->d_created_at;
}

function getMemberBid($mid)
{
    $member = Member::where('mid', $mid)->first();
    return $member->m_branch;
}

function getMemberBranch($bid)
{
    $branch = Branch::where('bid', $bid)->first();
    return $branch->bname;
}

function getRunningNo()
{
    $today = date('Y-m');
    $runno = InvoiceRunningNo::where('irn_date', $today)->max('irn_runningno');
    if($runno == "" || $runno == 0){
        $startnum = 1;

        $invoiceRunningNo = InvoiceRunningNo::create([
            'irn_date' => $today,
            'irn_runningno' => $startnum
        ]);
        return str_pad($startnum, 4, "0", STR_PAD_LEFT);
    } else {
        $continue = $runno+1;

        $invoiceRunningNo = InvoiceRunningNo::create([
            'irn_date' => $today,
            'irn_runningno' => $continue
        ]);
        return str_pad($continue, 4, "0", STR_PAD_LEFT);
    }
}

function chkMembershipNo($str)
{
    $member = Member::selectRaw("CONCAT(m_no_p1, m_no_p2, m_no_p3, m_no_p4, '/', m_no_p5) AS member_no, mid")
    ->where('m_no_p1', '!=', '')
    ->having('member_no', '=', $str)
    ->first();

    if($member) {
        return $member->mid;
    } else {
        return $member;
    }
}