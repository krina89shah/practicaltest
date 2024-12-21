<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Log;

class PostApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public static $bearerToken;
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user  = User::factory()->create();
        

        try {
            self::$bearerToken = $this->user->createToken('testcase')->accessToken;
            Log::info('Token Generated:', ['token' => self::$bearerToken]);
        } catch (\Exception $e) {
         
        }
     
        Passport::actingAs($this->user);
    }
 


    public function test_get_all_posts()
    {
        Post::factory()->count(3)->create();
       

        $response = $this->getJson('/api/posts', [
            'Authorization' => 'Bearer ' . self::$bearerToken,
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_create_post()
    {
        $data = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];

         
        $response = $this->postJson('/api/posts', $data, [
            'Authorization' => 'Bearer ' . self::$bearerToken,
        ]);

        
        $response->assertStatus(201);
        $response->assertJson($data);
        $this->assertDatabaseHas('posts', $data);
    }

    public function test_update_post()
    {
         
        $post = Post::factory()->create();
        $data = [
             'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];

         
        $response = $this->putJson("/api/posts/{$post->id}", $data, [
            'Authorization' => 'Bearer ' . self::$bearerToken,
        ]);

        
        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', $data);
    }

    public function test_delete_post()
    {
        $post = Post::factory()->create();
    
        $response = $this->deleteJson("/api/posts/{$post->id}", [], [
            'Authorization' => 'Bearer ' . self::$bearerToken,
        ]);
    
        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
    
    public function test_get_all_comments_for_post()
    {
        $post = Post::factory()->create();
        $comments = Comment::factory()->count(3)->create(['post_id' => $post->id]);

        $response = $this->getJson("/api/posts/{$post->id}/comments", [
            'Authorization' => 'Bearer ' . self::$bearerToken,
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonFragment(['post_id' => $post->id]);
    }

    public function test_create_comment_for_post()
    {
        $post = Post::factory()->create();
        $data = [
            'user_id' => $this->user->id,
            'post_id' => $post->id,
            'content' => $this->faker->paragraph,
        ];
    
        $response = $this->postJson("/api/posts/{$post->id}/comments", $data, [
            'Authorization' => 'Bearer ' . self::$bearerToken,
        ]);
    
        $response->assertStatus(201);
        $response->assertJson($data);
    }
    

    public function test_show_comment_for_post()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);
        Log::info($comment);
        $response = $this->getJson("/api/posts/{$post->id}/comments/{$comment->id}", [
            'Authorization' => 'Bearer ' . self::$bearerToken,
        ]);

        $response->assertStatus(200);
        Log::info($comment->content);
        $response->assertJson($comment->toArray());
    }

    public function test_update_comment_for_post()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);
        $data = [
            'user_id' => $this->user->id,
            'post_id' => $post->id,
            'content' => $this->faker->paragraph,
        ];

        $response = $this->putJson("/api/posts/{$post->id}/comments/{$comment->id}", $data, [
            'Authorization' => 'Bearer ' . self::$bearerToken,
        ]);

        $response->assertStatus(200);
        $response->assertJson($data);
    }

    public function test_delete_comment_for_post()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);

        $response = $this->deleteJson("/api/posts/{$post->id}/comments/{$comment->id}", [], [
            'Authorization' => 'Bearer ' . self::$bearerToken,
        ]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
    
}
