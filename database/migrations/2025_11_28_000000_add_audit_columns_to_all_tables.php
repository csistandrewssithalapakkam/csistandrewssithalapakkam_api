<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuditColumnsToAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add audit columns to tbl_user
        Schema::table('tbl_user', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_user', 'created_date')) {
                $table->timestamp('created_date')->useCurrent()->after('user_active');
            }
            if (!Schema::hasColumn('tbl_user', 'created_by')) {
                $table->integer('created_by')->nullable()->after('created_date');
            }
            if (!Schema::hasColumn('tbl_user', 'updated_date')) {
                $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate()->after('created_by');
            }
            if (!Schema::hasColumn('tbl_user', 'updated_by')) {
                $table->integer('updated_by')->nullable()->after('updated_date');
            }
        });

        // Add audit columns to tbl_members
        Schema::table('tbl_members', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_members', 'created_date')) {
                $table->timestamp('created_date')->useCurrent()->after('member_status');
            }
            if (!Schema::hasColumn('tbl_members', 'created_by')) {
                $table->integer('created_by')->nullable()->after('created_date');
            }
            if (!Schema::hasColumn('tbl_members', 'updated_date')) {
                $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate()->after('created_by');
            }
            if (!Schema::hasColumn('tbl_members', 'updated_by')) {
                $table->integer('updated_by')->nullable()->after('updated_date');
            }
        });

        // Add audit columns to tbl_family
        Schema::table('tbl_family', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_family', 'created_date')) {
                $table->timestamp('created_date')->useCurrent()->after('family_status');
            }
            if (!Schema::hasColumn('tbl_family', 'created_by')) {
                $table->timestamp('created_by')->nullable()->after('created_date');
            }
            if (!Schema::hasColumn('tbl_family', 'updated_date')) {
                $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate()->after('created_by');
            }
            if (!Schema::hasColumn('tbl_family', 'updated_by')) {
                $table->integer('updated_by')->nullable()->after('updated_date');
            }
        });

        // Add audit columns to tbl_verse
        Schema::table('tbl_verse', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_verse', 'created_date')) {
                $table->timestamp('created_date')->useCurrent()->after('verse_status');
            }
            if (!Schema::hasColumn('tbl_verse', 'created_by')) {
                $table->integer('created_by')->nullable()->after('created_date');
            }
            if (!Schema::hasColumn('tbl_verse', 'updated_date')) {
                $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate()->after('created_by');
            }
            if (!Schema::hasColumn('tbl_verse', 'updated_by')) {
                $table->integer('updated_by')->nullable()->after('updated_date');
            }
        });

        // Add audit columns to tbl_birthdays
        Schema::table('tbl_birthdays', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_birthdays', 'created_date')) {
                $table->timestamp('created_date')->useCurrent()->after('bd_date');
            }
            if (!Schema::hasColumn('tbl_birthdays', 'created_by')) {
                $table->integer('created_by')->nullable()->after('created_date');
            }
            if (!Schema::hasColumn('tbl_birthdays', 'updated_date')) {
                $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate()->after('created_by');
            }
            if (!Schema::hasColumn('tbl_birthdays', 'updated_by')) {
                $table->integer('updated_by')->nullable()->after('updated_date');
            }
        });

        // Add audit columns to tbl_wedding_anniversary
        Schema::table('tbl_wedding_anniversary', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_wedding_anniversary', 'created_date')) {
                $table->timestamp('created_date')->useCurrent()->after('wa_date');
            }
            if (!Schema::hasColumn('tbl_wedding_anniversary', 'created_by')) {
                $table->integer('created_by')->nullable()->after('created_date');
            }
            if (!Schema::hasColumn('tbl_wedding_anniversary', 'updated_date')) {
                $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate()->after('created_by');
            }
            if (!Schema::hasColumn('tbl_wedding_anniversary', 'updated_by')) {
                $table->integer('updated_by')->nullable()->after('updated_date');
            }
        });

        // Add audit columns to tbl_image_folder
        Schema::table('tbl_image_folder', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_image_folder', 'created_date')) {
                $table->timestamp('created_date')->useCurrent()->after('if_status');
            }
            if (!Schema::hasColumn('tbl_image_folder', 'created_by')) {
                $table->integer('created_by')->nullable()->after('created_date');
            }
            if (!Schema::hasColumn('tbl_image_folder', 'updated_date')) {
                $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate()->after('created_by');
            }
            if (!Schema::hasColumn('tbl_image_folder', 'updated_by')) {
                $table->integer('updated_by')->nullable()->after('updated_date');
            }
        });

        // Add audit columns to tbl_image_gallery
        Schema::table('tbl_image_gallery', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_image_gallery', 'created_date')) {
                $table->timestamp('created_date')->useCurrent()->after('ig_image_status');
            }
            if (!Schema::hasColumn('tbl_image_gallery', 'created_by')) {
                $table->integer('created_by')->nullable()->after('created_date');
            }
            if (!Schema::hasColumn('tbl_image_gallery', 'updated_date')) {
                $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate()->after('created_by');
            }
            if (!Schema::hasColumn('tbl_image_gallery', 'updated_by')) {
                $table->integer('updated_by')->nullable()->after('updated_date');
            }
        });

        // Add audit columns to tbl_prayer_request
        Schema::table('tbl_prayer_request', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_prayer_request', 'created_date')) {
                $table->timestamp('created_date')->useCurrent()->after('pr_status');
            }
            if (!Schema::hasColumn('tbl_prayer_request', 'created_by')) {
                $table->integer('created_by')->nullable()->after('created_date');
            }
            if (!Schema::hasColumn('tbl_prayer_request', 'updated_date')) {
                $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate()->after('created_by');
            }
            if (!Schema::hasColumn('tbl_prayer_request', 'updated_by')) {
                $table->integer('updated_by')->nullable()->after('updated_date');
            }
        });

        // Add audit columns to tbl_hero_banner
        Schema::table('tbl_hero_banner', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_hero_banner', 'created_date')) {
                $table->timestamp('created_date')->useCurrent()->after('hb_status');
            }
            if (!Schema::hasColumn('tbl_hero_banner', 'created_by')) {
                $table->integer('created_by')->nullable()->after('created_date');
            }
            if (!Schema::hasColumn('tbl_hero_banner', 'updated_date')) {
                $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate()->after('created_by');
            }
            if (!Schema::hasColumn('tbl_hero_banner', 'updated_by')) {
                $table->integer('updated_by')->nullable()->after('updated_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = [
            'tbl_user',
            'tbl_members',
            'tbl_family',
            'tbl_verse',
            'tbl_birthdays',
            'tbl_wedding_anniversary',
            'tbl_image_folder',
            'tbl_image_gallery',
            'tbl_prayer_request',
            'tbl_hero_banner',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (Schema::hasColumn($table, 'created_date')) {
                    $table->dropColumn('created_date');
                }
                if (Schema::hasColumn($table, 'created_by')) {
                    $table->dropColumn('created_by');
                }
                if (Schema::hasColumn($table, 'updated_date')) {
                    $table->dropColumn('updated_date');
                }
                if (Schema::hasColumn($table, 'updated_by')) {
                    $table->dropColumn('updated_by');
                }
            });
        }
    }
}
