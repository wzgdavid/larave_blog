<?php  namespace App\Repositories;
/**
 * Class GroupRepository
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaravelAcl\Library\Repository\Interfaces\BaseRepositoryInterface;
use LaravelAcl\Authentication\Models\Group;
use LaravelAcl\Authentication\Exceptions\UserNotFoundException as NotFoundException;
use App, Event, Config;
use Cartalyst\Sentry\Groups\GroupNotFoundException;
use App\Article;


class ArticleRepository
{
    /**
     * Sentry instance
     * @var
     */
    protected $sentry;


    public function __construct($config_reader = null)
    {

        $this->config_reader = $config_reader ? $config_reader : App::make('config');
        $this->articles_per_page = $this->config_reader->get('acl_base.articles_per_page');
    }

    /**
     * Create a new object
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->sentry->createGroup($data);
    }

    /**
     * Update a new object
     *
     * @param       id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        $obj = $this->find($id);
        Event::fire('repository.updating', [$obj]);
        $obj->update($data);
        return $obj;
    }


    public function delete($id)
    {
        //$obj = $this->find($id);
        //Event::fire('repository.deleting', [$obj]);
        //return $obj->delete();
        Article::destroy($id);
    }

    public function get_articles()
    {
         return Article::where('is_approved', 1)
            ->orderBy('date_created', 'desc')
            ->paginate($this->articles_per_page); 
    }

    /**
     * Find a model by his id
     *
     * @param $id
     * @return mixed
     * @throws \LaravelAcl\Authentication\Exceptions\UserNotFoundException
     */
    public function find($id)
    {
        try
        {
            $group = $this->sentry->findGroupById($id);
        }
        catch(GroupNotFoundException $e)
        {
            throw new NotFoundException;
        }

        return $group;
    }


}