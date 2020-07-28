# Notifly
Notifly allows aggregating notification actors like Facebook, Twitter, Instagram and etc -- (`John Doe, Jane Doe and 8
 others reacted to your photo.`) A notification consists of an `actor`, a `verb`, an `object` and a `target`. It
  tells the story of a person performing an action on or with an object.
 
 # Creating Notifications
 In Notifly, the same as In Laravel, each notification is represented by a single class (typically stored in the `app/Notifications` directory). you can create a notification class by running the `notifly:make:notification` Artisan
  command.
  
  `php artisan notifly:make:notification CommentNotification`
  
  This command will place a fresh notification class in your `app/Notifications` directory. Each notification class
   contains a `via` method which returns an array of supported channels. It returns `NotiflyChannel` by default, you
    can append any required channels. The `NotiflyChannel` replaces Laravel's database channel, but any other message
     building channels such as `toMail` are supported the same as expected in a normal notification class. 
     
# Sending Notifications

The Notified user model must implement the `TransformableInterface`, don't worry about the required methods, they are
 implemented in the `Notifiable` from **Piscibus** not ~~Laravel~~. Let's explore a `User` model example.
 
 ```php
<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Piscibus\Notifly\Contracts\TransformableInterface;
use Piscibus\Notifly\Traits\Notifiable;

class User extends Authenticatable implements TransformableInterface
{
    use Notifiable;
}
```

This trait contains a `notify` method which expects to receive a notification instance.

```php
use App\Notifications\CommentNotification;

$user->notify(new CommentNotification($actor, $object, $target));
```

In the previous example, the `$actor` is the user who commented on the `$user`'s post. The `$object` is the comment
 itself. Finally, the `$target` is the post the `$actor` commented on.
 
 All those required entities (`$actor`, `$object` and `$target`) must implement the `TransformableInterface`, and again don't worry about the required
  methods, they are implemented in `Notifly` Trait.
  
```php
<?php
use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\TransformableInterface;
use Piscibus\Notifly\Traits\Notifly;

class Comment extends Model implements TransformableInterface
{
    use Notifly;
}
```

Since the `User` model, may represent an actor and a notifiable in the same time, the required methods are provided
 by a `Notifibale` trait.
 
 ## tl;dr
 - All models used in notifications should implement `\Piscibus\Notifly\Contracts\TransformableInterface`
 - The Notified model -- (`User`) uses the `\Piscibus\Notifly\Traits\Notifiable` trait.
 - Any other models -- (`Comment`, `Post`) uses `\Piscibus\Notifly\Traits\Notifly` trait.
 
 ## Formatting Notifications
 The notification class contains an attribute `$verb`, replace its value with a descriptive word. Let's Explore a
  `CommentNotification` class.
  
 ```php
<?php
use Piscibus\Notifly\Notifications\Notification;

class CommentNotification extends Notification
{
    /**
     * @var string
     */
    protected $verb = 'comment';
}
```
A Notification usually has an icon, the icon is represented by an array in the JSON response. To customize a
 notification icon, you need to create an icon class, and register this icon class in the configuration file `configs
 /notifly.php`. To generate an icon class run the `notifly:make:icon` Artisan command.
 
 `php artisan notifly:make:icon CommentNotificationIcon`
 
 This command will place a fresh Icon class in the `app/Icons` directory.
 
 ```php
<?php
namespace App\Icons;
use Piscibus\Notifly\Notifications\Icon;

class CommentNotificationIcon extends Icon
{
     /**
         * Get notification icon attributes
         *
         * @return array
         */
        public function toArray(): array
        {
            return [
                'width' => 0,
                'height' => 0,
                'uri' => null,
            ];
        }
}
```
```php
//configs/notifly.php
return [
// ..
    'icons' => [
         'comment' => CommentNotificationIcon::class,
    ]   
//    
];

```

Within the `toArray` method you can access all entities of the notification.
- `$this->actors` a collection of the notification actors.
- `$this->object` the notification object.
- `$this->target` the notification target.

Use them to customize the notification icon.

# Accessing The Notifications

Once notifications are stored in the database, you need a convenient way to access them from your notifiable entities
. The `\Piscibus\Notifly\Traits\Notifiable` includes a `notifications` Eloquent relationship that returns the "un-read"
 notifications for the entity. To fetch notifications, you may access this method like any other Eloquent
  relationships. By default, notifications will be sorted by the `updated_at` timestamp.
  
```php
$user = App\User::find(1);
foreach ($user->notifications as $notification){
    echo $notification->verb;
}
```

If you want to retrieve the "un-seen" notifications, you may use the `unseenNotifications` relationship. Again, these
 notifications will be sorted by the `updated_at` timestamp.
 
```php
$user = App\User::find(1);
$bellCount = $user->unseenNotifications()->count();

foreach ($user->unseenNotifications as $notification){
     echo $notification->verb;
}
```

If you want to retrieve the "read" notifications, you may use the "readNotifications" relationship. Again, these
 notifications will be sorted by the `updated_at` timestamp.
 
```php
$user = App\User::find(1);
foreach ($user->unreadNotifications as $notification) {
    echo $notification->type;
}
```

# Marking Notifications As Seen

Typically, you will want to mark a notification as "seen" when a user retrieves the notification list. The `\Piscibus\Notifly\Traits\Notifiable` provides a `markAsSeen` method, wich updates the `seen_at` column on the notification's database record:
```php
$user = App\User::find(1);
foreach($user->unseenNotifications as $notificaion) {
    $notification->markAsSeen();
}
```

However, instead of looping throug each notification, you may use the `markAsSeen` method directoy on a collection of notifications.
```php
$user->unseenNotifications->markAsSeen();
```

You may also use a mass-update query to mark all the notifications as seen without retrieving them from the database:
```php
$user = App\User::find(1);
$user->unseenNotifications()->update(['seen_at' => now()]);
```

You may `delete` the notifications to remove them from the table entirley:
```php
$user->notifications()->delete();
```

# Marking Notifications As Read
Typically, you will want to mark a notification as "read" when a user views it. You may use the `markAsRead` method, which deletes this notification entry and creates a new entry in the `read_notification`table:
```php
$user = App\User::find(1);
foreach($user->notifications as $notification) {
    $readNotification = $notification->markAsRead();
}
```
If you want to mark a read-notification as "unread", you may use `markAsUnRead` method, which reverses the previouls process of marking the notification as read.
```php
$user = App\User::find(1);
foreach($user->readNotifications as $notification) {
    $notification->markAsUnRead();
}
```

# Notifications In A JSON Response
Typically, you will want to provied a JSON response of a notifiable notifications. You may use the `\Piscibus\Notifly\Resources\JsonNotifications` JSON resource.
To avoid "N+1" queriers, the `\Piscibus\Notifly\Traits\Notifiable` has a `jsonableNotifications` and `jsonableReadNotifications` relationships which eagrly load the required relations:
```php
Route::get('/notifications', function(){
    $user = App\User::find(1);
    $notifications = $user->jsonableNotifications;
    return JsonNotifications::collection($notifications);
})
```

A notification JSON appears as follows:
```Javascript
{
    "id": "9122a3cb-b4e3-352a-a1ab-087e259403af",
    "verb": "comment",
    "time": "2020-07-26T16:07:10.000000Z",
    "object" : {
        "id" : 7,
        //...
    },
    "target": {
        "id": 9
    },
    "actors": {
        "data": [
            {
                "id": 1990,
                //...
            },
            {
                "id": 1995,
                //...
            }
        ],
        "trimmed": 8
    },
    "icon": {
        "width": 500,
        "height": 500,
        "uri": "https://example.com/path/to/image.jpg"
    }
}
```

# Customizing The Notification entities JSON
To customize a notification JSON, create an [Eloquent API Resource](https://laravel.com/docs/eloquent-resources), then override the `getTransformer` in the entity model class. In a `John commented on your post` case, the object is a `Comment` model, to customize its JSON:

`php artisan make:resource Comment`

```php
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\TransformableInterface;
use Piscibus\Notifly\Traits\Notifiable;
use App\Http\Resources\Comment as CommentResource;

class Comment extends Model implements TransformableInterface
{
     use Notifiable;
    
    /**
    * Gets the Eloquent API Resource
    **/
    public function getTransformer(): JsonResource
    {
        return new CommentResource($this);
    }
}
```

For more information about [Eloquent API Resource](https://laravel.com/docs/eloquent-resources), check Laravel documentation.
