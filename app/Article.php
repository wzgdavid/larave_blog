<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use APP\ArticleAuthor;

class Article extends Model
{
    protected $table = 'article';


    public function get_author()
    {
    	$author = ArticleAuthor::find($this->author_id);
    	return $author->author_name;
    }
}
