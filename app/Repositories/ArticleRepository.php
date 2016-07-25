<?php  namespace App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaravelAcl\Library\Repository\Interfaces\BaseRepositoryInterface;
use LaravelAcl\Authentication\Models\Group;
use LaravelAcl\Authentication\Exceptions\UserNotFoundException as NotFoundException;
use App, Event, Config;
use Cartalyst\Sentry\Groups\GroupNotFoundException;
use App\Article;


class ArticleRepository
{


    public function __construct($config_reader = null)
    {

        $this->config_reader = $config_reader ? $config_reader : App::make('config');
        $this->articles_per_page = $this->config_reader->get('acl_base.articles_per_page');
    }


    public function delete($id)
    {
        Article::destroy($id);
    }

    public function get_articles()
    {
        return Article::where('is_approved', 1)
            ->orderBy('date_created', 'desc')
            ->paginate($this->articles_per_page); 
    }




}