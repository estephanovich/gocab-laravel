<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Update wallet history transaction descriptions to use simplified referral bonus descriptions
     * for the two core bonus types only: "Referrer Bonus" and "Referred Bonus"
     */
    public function up(): void
    {
        // Check if CabBooking module tables exist
        if (Schema::hasTable('rider_wallet_histories') && Schema::hasTable('driver_wallet_histories')) {

            // Update rider wallet history descriptions for simplified referral bonuses
            DB::table('rider_wallet_histories')
                ->where('detail', 'LIKE', '%Welcome Bonus%')
                ->update(['detail' => DB::raw("REPLACE(detail, 'Welcome Bonus', 'Referred Bonus')")]);

            DB::table('rider_wallet_histories')
                ->where('detail', 'LIKE', '%Legacy Referral Bonus%')
                ->update(['detail' => DB::raw("REPLACE(detail, 'Legacy Referral Bonus', 'Referrer Bonus')")]);

            // Standardize any existing "Referral Bonus" to "Referrer Bonus" for consistency
            DB::table('rider_wallet_histories')
                ->where('detail', 'LIKE', '%Referral Bonus%')
                ->where('detail', 'NOT LIKE', '%Referrer Bonus%')
                ->where('detail', 'NOT LIKE', '%Referred Bonus%')
                ->update(['detail' => DB::raw("REPLACE(detail, 'Referral Bonus', 'Referrer Bonus')")]);

            // Update driver wallet history descriptions for simplified referral bonuses
            DB::table('driver_wallet_histories')
                ->where('detail', 'LIKE', '%Welcome Bonus%')
                ->update(['detail' => DB::raw("REPLACE(detail, 'Welcome Bonus', 'Referred Bonus')")]);

            DB::table('driver_wallet_histories')
                ->where('detail', 'LIKE', '%Legacy Referral Bonus%')
                ->update(['detail' => DB::raw("REPLACE(detail, 'Legacy Referral Bonus', 'Referrer Bonus')")]);

            // Standardize any existing "Referral Bonus" to "Referrer Bonus" for consistency
            DB::table('driver_wallet_histories')
                ->where('detail', 'LIKE', '%Referral Bonus%')
                ->where('detail', 'NOT LIKE', '%Referrer Bonus%')
                ->where('detail', 'NOT LIKE', '%Referred Bonus%')
                ->update(['detail' => DB::raw("REPLACE(detail, 'Referral Bonus', 'Referrer Bonus')")]);

            \Log::info('Updated wallet history referral descriptions to use simplified two core bonus types');
        }
    }

    /**
     * Reverse the migrations.
     *
     * Revert wallet history descriptions back to legacy format
     */
    public function down(): void
    {
        // Check if CabBooking module tables exist
        if (Schema::hasTable('rider_wallet_histories') && Schema::hasTable('driver_wallet_histories')) {

            // Revert rider wallet history descriptions
            DB::table('rider_wallet_histories')
                ->where('detail', 'LIKE', '%Referred Bonus%')
                ->update(['detail' => DB::raw("REPLACE(detail, 'Referred Bonus', 'Welcome Bonus')")]);

            DB::table('rider_wallet_histories')
                ->where('detail', 'LIKE', '%Referrer Bonus%')
                ->update(['detail' => DB::raw("REPLACE(detail, 'Referrer Bonus', 'Referral Bonus')")]);

            // Revert driver wallet history descriptions
            DB::table('driver_wallet_histories')
                ->where('detail', 'LIKE', '%Referred Bonus%')
                ->update(['detail' => DB::raw("REPLACE(detail, 'Referred Bonus', 'Welcome Bonus')")]);

            DB::table('driver_wallet_histories')
                ->where('detail', 'LIKE', '%Referrer Bonus%')
                ->update(['detail' => DB::raw("REPLACE(detail, 'Referrer Bonus', 'Referral Bonus')")]);

            \Log::info('Reverted wallet history referral descriptions to legacy format');
        }
    }
};
