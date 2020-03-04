<?php

namespace Blogs\Models;

class PostNull extends Post {
    
    public function getPostId() :string{
        return "null";
    }
    public function getContent() :string{
        return "null";
    }
    public function getUserId() :string{
        return "null";
    }
}