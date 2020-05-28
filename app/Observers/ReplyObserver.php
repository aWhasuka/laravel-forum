<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();

        // 通知话题作者有新的评论
        /**
         * 请注意顶部引入 TopicReplied 。
         * 默认的 User 模型中使用了 trait —— Notifiable，
         * 它包含着一个可以用来发通知的方法 notify() ，此方法接收一个通知实例做参数。虽然 notify() 已经很方便，
         * 但是我们还需要对其进行定制，我们希望每一次在调用 $user->notify() 时，自动将 users 表里的 notification_count +1 ，
         * 这样我们就能跟踪用户未读通知了。
         */
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }
}
