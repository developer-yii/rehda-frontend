<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MemberComp;
use App\Models\MemberUserProfile;
use App\Models\Member;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mid =1937;
        $userProfile = MemberUserProfile::whereHas('memberComp', function ($query) use ($mid) {
            $query->where('d_mid', $mid);
        })->first();

        $mno = $userProfile->up_mykad;
        echo $mno; die;

        pr($userProfile);

        echo now()->format('y'); die;
        $memberComp = MemberComp::find(2);
        echo $memberComp->member->memberType->typename;
        die;
    }
}
