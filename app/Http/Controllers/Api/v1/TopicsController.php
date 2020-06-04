<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Resources\TopicResource;
use App\Http\Requests\Api\TopicRequest;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Models\User;

class TopicsController extends Controller
{
    public function show(Topic $topic)
    {
        return new TopicResource($topic);
    }

    public function userIndex(Request $request, User $user)
    {
        $query = $user->topics()->getQuery();

        $topics = QueryBuilder::for($query)->allowedIncludes(['user', 'category'])
            ->allowedFilters([
                'title',
                AllowedFilter::exact('category_id'),
                AllowedFilter::scope('withOrder')->default('recentReplied')
            ])->paginate();

        return TopicResource::collection($topics);
    }

    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->save();

        return new TopicResource($topic);
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        // 授权策略
        $this->authorize('update', $topic);

        $topic->update($request->all());
        return new TopicResource($topic);
    }

    public function destroy(Topic $topic)
    {
        // 使用的是 destroy 的权限控制，判断用户是否有权限删除
        $this->authorize('destroy', $topic);

        $topic->delete();

        return response(null, 204);
    }

    public function index(Request $request, Topic $topic)
    {
//        $query = $topic->query();

//        if ($categoryId = $request->category_id) {
//            $query->where('category_id', $categoryId);
//        }
//
//        // with 预加载
//        $topic = $query->with('user', 'category')->withOrder($request->order)->paginate();

        /**
         * allowedFilters 方法传入可以被搜索的条件，可以传入某个字段，
         * 例如这里传入了 title，这样会模糊搜索标题；如果某个字段是精确搜索需要进行指定，
         * 这里我们指定 category_id 是精确搜索的；还可以传入某个 scope，并且制定默认的参数，
         * 例如这里我们指定可以使用 withOrder 进行搜索，默认的值是 recentReplied
         */
        $topic = QueryBuilder::for(Topic::class)->allowedIncludes('user', 'category')
            // 使用 filter 参数可以进行搜索，该参数是个数组。
            ->allowedFilters([
                'title',
                AllowedFilter::exact('category_id'),
                AllowedFilter::scope('withOrder')->default('recentReplied')
        ])->paginate();

        return TopicResource::collection($topic);
    }
}
