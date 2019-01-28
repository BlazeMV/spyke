<?php

namespace Blaze\Spyke\Api\Requests;

use Illuminate\Support\Collection;

class Fetch extends BaseRequest
{
    /**
     * @return string
     */
    protected function responseObject() : string
    {
        return Collection::class;
    }
    
    /**
     * @param string $id
     * @return $this
     */
    public function id(string $id)
    {
        $this->params['i'] = $id;
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function title(string $title)
    {
        $this->params['t'] = $title;
        return $this;
    }

    /**
     * @param string $search
     * @return $this
     */
    public function search(string $search)
    {
        $this->params['s'] = $search;
        return $this;
    }

    /**
     * @param int $year
     * @return $this
     */
    public function year(int $year)
    {
        $this->params['y'] = $year;
        return $this;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function page(int $page)
    {
        $this->params['page'] = $page;
        return $this;
    }

    /**
     * @return $this
     */
    public function movie()
    {
        $this->params['type'] = 'movie';
        return $this;
    }

    /**
     * @return $this
     */
    public function series()
    {
        $this->params['type'] = 'series';
        return $this;
    }

    /**
     * @param int|null $episode
     * @return $this
     */
    public function episode(int $episode=null)
    {
        if ($episode === null) {
            $this->params['type'] = 'episode';
        } else {
            $this->params['episode'] = $episode;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function shortPlot()
    {
        $this->params['plot'] = 'short';
        return $this;
    }

    /**
     * @return $this
     */
    public function fullPlot()
    {
        $this->params['plot'] = 'full';
        return $this;
    }

    /**
     * @param int $season
     * @return $this
     */
    public function season(int $season)
    {
        $this->params['season'] = $season;
        return $this;
    }
}
