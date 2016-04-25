<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use APP\ArticleAuthor;

class Article extends Model
{
    //protected $table = 'article';


    public function get_author()
    {   
    	$aid = $this->author_id;
    	if ($aid == 0) {
    		$rtn = '(None)';
    	}else{
    		$author = ArticleAuthor::find($aid);
    		$rtn = $author->author_name;
        }
    	return $rtn;
    }
}
