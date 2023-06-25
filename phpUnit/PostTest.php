<?php

use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testGetPostById()
    {
        // Create a mock database connection
        $conn = $this->getMockBuilder(mysqli::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockResult = $this->getMockBuilder(mysqli_result::class)
            ->disableOriginalConstructor()
            ->getMock();

        $expectedRow = [
            'id' => 1,
            'title' => 'Test Post',
            'body' => 'This is a test post.',
            'created_at' => '2022-01-01 12:00:00',
            'updated_at' => '2022-01-01 12:00:00',
        ];

        $mockResult->expects($this->once())
            ->method('fetch_assoc')
            ->willReturn($expectedRow);

        $conn->expects($this->once())
            ->method('query')
            ->willReturn($mockResult);

        $post = new Post($conn);

        $result = $post->getPostById(1);

        $this->assertEquals($expectedRow, $result);
    }

    public function testAddPost()
    {
        $conn = $this->getMockBuilder(mysqli::class)
            ->disableOriginalConstructor()
            ->getMock();

        $newPostData = [
            'title' => 'New Post',
            'body' => 'This is a new post.',
        ];

        $conn->expects($this->once())
            ->method('query')
            ->with("INSERT INTO posts (title, body) VALUES ('New Post', 'This is a new post.')");

        $post = new Post($conn);

        $result = $post->addPost($newPostData);

        $this->assertTrue($result);
    }
}

?>
