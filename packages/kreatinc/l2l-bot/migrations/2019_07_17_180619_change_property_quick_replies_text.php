<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Kreatinc\Bot\Models\FieldChoice;

class ChangePropertyQuickRepliesText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        FieldChoice::where('text', 'Single Family Residence')->update([
            'text'    => 'Residence',
            'payload' => 'Residence',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        FieldChoice::where('text', 'Residence')->update([
            'text'    => 'Single Family Residence',
            'payload' => 'Single Family Residence',
        ]);
    }
}
