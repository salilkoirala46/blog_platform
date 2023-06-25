<?php
class Comment
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createComment($postID, $userName, $commentBody)
    {
        $query = "INSERT INTO comments (post_id, user_name, body) VALUES ('$postID', '$userName', '$commentBody')";
        if ($this->conn->query($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function getCommentsByPostID($postID)
    {
        $query = "SELECT * FROM comments WHERE post_id = '$postID'";
        $result = $this->conn->query($query);

        $comments = array();
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }

        return $comments;
    }
}
?>
