22222222222222222
column add
php artisan make:migration add_is_read_to_notifications_table --table=notifications

22222222222222222
check zip enable aur not
php -m
php --ini

if not enable
C:\xampp\php\php.ini

find extension=zip and uncomment it


2222222222
// jab laravel ke storage me image ho tab
php artisan storage:link


<td>
    <a target="_blank" href="{{ asset('storage/image/task/' . $assignmentfolderData->filesname) }}">
        {{ $assignmentfolderData->filesname ?? '' }}
    </a>
</td>
2222222222222222
migration table structure


class CreateTimesheetupdatelogsTable extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
public function up()
{
Schema::create('timesheetupdatelogs', function (Blueprint $table) {
$table->id();
$table->integer('timesheetusers_id');
$table->tinyInteger('status')->nullable();
$table->timestamps();
});
}

/**
* Reverse the migrations.
*
* @return void
*/
public function down()
{
Schema::dropIfExists('timesheetupdatelogs');
}
}
