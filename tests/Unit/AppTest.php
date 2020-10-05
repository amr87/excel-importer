<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AppTest extends TestCase
{
    use WithFaker;


    /**
     * Undocumented function
     *
     * @return void
     */
    public function testAuth()
    {
        $user = User::create([
            'email' => $this->faker->email,
            'name'  => $this->faker->name,
            'password' => Hash::make('password')
        ]);
        
        Auth::login($user);

        $this->assertAuthenticatedAs($user);
    }
    /**
     * @depends testAuth
     *
     * @return void
     */
    public function testUpload()
    {
        $user = User::create([
            'email' => $this->faker->email,
            'name'  => $this->faker->name,
            'password' => Hash::make('password')
        ]);

        Auth::login($user);

        $baseFile =  new UploadedFile(
            public_path('/books.xls'),
            'books.xls',
            'application/vnd.ms-excel',
            6656,
            null,
            true
        );
        
        $file = UploadedFile::createFromBase($baseFile);

        $response = $this->actingAs($user)->json('POST', route('processImport'), [
            'sheet' => $file,
        ]);

        $response->assertSessionHas('success', 'file import is on progress!');
    }


    /**
     * @depends testUpload
     *
     * @return void
     */
    public function testDataInserted()
    {
        $this->assertDatabaseHas('books', [
            'title' => [
                'book #1',
                'book #2',
                'book #3',
                'book #4',
                'book #6',
                'book #7',
                'book #8',
                'book #9',
            ],
        ]);
    }
}
