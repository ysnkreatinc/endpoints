<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Kreatinc\Bot\Models\FieldChoice;

class ChangePropertyQuickRepliesText2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        FieldChoice::where('text', 'Residence')->update([
            'text'    => 'Single Family Home',
            'payload' => 'Single Family Home',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        FieldChoice::where('text', 'Single Family Home')->update([
            'text'    => 'Residence',
            'payload' => 'Residence',
        ]);
    }
}
