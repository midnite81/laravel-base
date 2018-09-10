<?php
namespace Midnite81\LaravelBase\Traits;

use Illuminate\Http\Request;

trait Searchable
{
    /**
     * Save search term to
     *
     * @return mixed
     */
    public function search()
    {
        if (request()->get('query') == "") {
            return $this->reset();
        }
        
        session()->put($this->getSearchableKey(), request()->get('query'));

        if (request()->redirectUri) {
            return redirect()->to(request()->redirectUri);
        }

        return redirect()->to($this->previousUrl());
    }

    /**
     * Reset Search Term
     *
     * @return mixed
     */
    public function reset()
    {
        session()->forget($this->getSearchableKey());

        if (request()->redirectUri) {
            return redirect()->to(request()->redirectUri);
        }

        return redirect()->to($this->previousUrl());
    }


    /**
     * Get Searchable Key
     *
     * @return string
     */
    protected function getSearchableKey()
    {
        if (property_exists($this, 'searchableKey')) {
            return $this->searchableKey;
        }
        return str_replace('\\', '.', get_class($this)) . '.search';
    }

    /**
     * Get the search term
     */
    protected function getSearchTerm()
    {
        return trim(session()->get($this->getSearchableKey()));
    }


    /**
     * If search is active
     */
    protected function isSearched()
    {
        return session()->has($this->getSearchableKey());
    }

    /**
     * Get the previous url, minus the query string
     */
    protected function previousUrl()
    {
        return preg_replace('/\?(.*?)$/', '', url()->previous());
    }

    /**
     * Search terms
     *
     * @param       $table
     * @param array $columns
     * @param bool $split
     * @param bool $matchAny
     */
    protected function filterByTerms($table, array $columns, $split = true, $matchAny = true)
    {
        $searchTermsSplit = explode(' ', $this->getSearchTerm());

        if ($split) {
            $table->filter(function ($q) use ($columns, $matchAny, $searchTermsSplit) {
                if ( ! empty($columns) && ! empty($searchTermsSplit)) {
                    foreach ($columns as $key => $column) {
                        if ( ! $key) {
                            $q->where(function ($query) use ($searchTermsSplit, $column, $matchAny) {
                                foreach ($searchTermsSplit as $key => $term) {
                                    if ( ! $key) {
                                        $query->where($column, 'LIKE', '%' . $term . "%");
                                    } else {
                                        if ($matchAny) {
                                            $query->orWhere($column, 'LIKE', '%' . $term . "%");
                                        } else {
                                            $query->where($column, 'LIKE', '%' . $term . "%");
                                        }
                                    }
                                }
                            });
                        } else {
                            $q->orWhere(function ($query) use ($searchTermsSplit, $column, $matchAny) {
                                foreach ($searchTermsSplit as $key => $term) {
                                    if ( ! $key) {
                                        $query->where($column, 'LIKE', '%' . $term . "%");
                                    } else {
                                        if ($matchAny) {
                                            $query->orWhere($column, 'LIKE', '%' . $term . "%");
                                        } else {
                                            $query->where($column, 'LIKE', '%' . $term . "%");
                                        }
                                    }
                                }
                            });
                        }
                    }
                }
            });
        } else {
            $table->filter(function ($q) use ($columns) {
                foreach ($columns as $key => $column) {
                    if ( ! $key) {
                        $q->where($column, 'LIKE', '%' . $this->getSearchTerm() . "%");
                    } else {
                        $q->orWhere($column, 'LIKE', '%' . $this->getSearchTerm() . "%");
                    }
                }
            });
        }
    }

    /**
     * Search terms
     *
     * @param       $model
     * @param array $columns
     * @param bool  $split
     * @param bool  $matchAny
     * @return mixed
     */
    protected function filterModelByTerms($model, array $columns, $split = true, $matchAny = true)
    {
        $searchTermsSplit = explode(' ', $this->getSearchTerm());
        if ($split) {
            $model = $model->where(function ($q) use ($columns, $matchAny, $searchTermsSplit) {
                if ( ! empty($columns) && ! empty($searchTermsSplit)) {
                    foreach ($columns as $key => $column) {
                        if ( ! $key) {
                            $q->where(function ($query) use ($searchTermsSplit, $column, $matchAny) {
                                foreach ($searchTermsSplit as $key => $term) {
                                    if ( ! $key) {
                                        $query->where($column, 'LIKE', '%' . $term . "%");
                                    } else {
                                        if ($matchAny) {
                                            $query->orWhere($column, 'LIKE', '%' . $term . "%");
                                        } else {
                                            $query->where($column, 'LIKE', '%' . $term . "%");
                                        }
                                    }
                                }
                            });
                        } else {
                            $q->orWhere(function ($query) use ($searchTermsSplit, $column, $matchAny) {
                                foreach ($searchTermsSplit as $key => $term) {
                                    if ( ! $key) {
                                        $query->where($column, 'LIKE', '%' . $term . "%");
                                    } else {
                                        if ($matchAny) {
                                            $query->orWhere($column, 'LIKE', '%' . $term . "%");
                                        } else {
                                            $query->where($column, 'LIKE', '%' . $term . "%");
                                        }
                                    }
                                }
                            });
                        }
                    }
                }
            });
        } else {
            $model = $model->where(function ($q) use ($columns) {
                foreach ($columns as $key => $column) {
                    if ( ! $key) {
                        $q->where($column, 'LIKE', '%' . $this->getSearchTerm() . "%");
                    } else {
                        $q->orWhere($column, 'LIKE', '%' . $this->getSearchTerm() . "%");
                    }
                }
            });
        }
        return $model;
    }
}
