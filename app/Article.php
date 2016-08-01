<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use APP\ArticleAuthor;

class Article extends Model
{
    protected $table = 'article';
    const UPDATED_AT = 'date_modified';
    const CREATED_AT = 'date_created';
    
    use \Conner\Tagging\Taggable;

    protected $fillable = [
        'is_approved',
        'is_welcome',
        'is_home_featured',
        'is_homepage_sponsored',
        'is_shf_featured',
        'is_shf_sponsored',
        'is_in_sitemap',
        'is_proofread',
        'shf_priority',
        'datetime_publish',
        'datetime_unpublish',

        'title',
        'subtitle',
        'user_id',
        'category_id',
        'author_id',
        'related_threads',
        'pic',
        'content',
        'page_title',
        'meta_description',
        'keywords',
        'hyperlink',

        ];



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
