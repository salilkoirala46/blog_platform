<?php

class Post
{
    private $mysqli;

    public function __construct(mysqli $mysqli) {

        $this->mysqli = $mysqli;
    
    }

    //function to create post
    public function createPost($title, $body)
    {

        $query = "INSERT INTO posts (title, body) VALUES ('$title', '$body')";
        $result = $this->mysqli->query($query);

        if ($result) {

            return $this->mysqli->insert_id; 
        
        } else {
            
            return false; 
        
        }
    }

    //function to update post 
    public function updatePost($postId, $title, $body)
    {

        $query = "UPDATE posts SET title = '$title', body = '$body' WHERE id = $postId";
        $result = $this->mysqli->query($query);

        if ($result && $this->mysqli->affected_rows === 1) {

            return true;

        } else {

            return false; 

        }
    }

    // function to delete post
    public function deletePost($postId)
    {
        $query = "DELETE FROM posts WHERE id = $postId";
        $result = $this->mysqli->query($query);

        if ($result && $this->mysqli->affected_rows === 1) {

            return true;

        } else {

            return false;

        }
    }
    
    public function getAllPosts($page = 1, $perPage = 2)
    {
        $offset = ($page - 1) * $perPage;
        $query = "SELECT * FROM posts ORDER BY created_at DESC LIMIT $offset, $perPage";
        $result = $this->mysqli->query($query);

        $posts = array();
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
        }

        return $posts;
    }

    public function getPostById($id)
    {
        $query = "SELECT * FROM posts where id=".$id;

        // Execute the query
        $result = $this->mysqli->query($query);
        $row = $result->fetch_assoc();

        return $row;
    }

    public function getTotalPostsCount()
    {
        $query = "SELECT COUNT(*) AS total FROM posts";
        $result = $this->mysqli->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }

        return 0;
    }

}
