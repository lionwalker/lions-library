<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * test if book can be added to the library
     */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Cool book title',
            'author' => 'LWalker'
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /**
     * @test
     * test if book title is required
     */
    public function a_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'LWalker'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /**
     * @test
     * test if book author is required
     */
    public function a_author_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'Cool book title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /**
     * @test
     * test if book can be updated
     */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool book title',
            'author' => 'LWalker'
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New book title',
            'author' => 'Lion Walker'
        ]);

        $this->assertEquals('New book title', Book::first()->title);
        $this->assertEquals('Lion Walker', Book::first()->author);
        $response->assertRedirect($book->fresh()->path());
    }

    /**
     * @test
     * test if book can be deleted
     */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool book title',
            'author' => 'LWalker'
        ]);

        $book = Book::first();

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
}
