<?php

namespace SamAsEnd\QueryDiagnosis\Tests\Seeder;

use Illuminate\Database\Seeder;
use SamAsEnd\QueryDiagnosis\Tests\Models\Author;
use SamAsEnd\QueryDiagnosis\Tests\Models\Comment;
use SamAsEnd\QueryDiagnosis\Tests\Models\Post;
use SamAsEnd\QueryDiagnosis\Tests\Models\Profile;

class TestSeeder extends Seeder
{
    public function run()
    {
        $authors = factory(Author::class, 25)->create();

        $authors->each(function (Author $author) {
            factory(Profile::class)->create([
                'author_id' => $author->id,
            ]);

            $posts = factory(Post::class, 5)->create([
                'author_id' => $author->id,
            ]);

            $posts->each(fn(Post $post) => factory(Comment::class, 2)->create([
                'commentable_id' => $post->id,
                'commentable_type' => Post::class,
            ]));
        });
    }
}
