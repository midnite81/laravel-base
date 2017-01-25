# Adding search to your controller 
(This is a work in progress ... docs will be updated in due course)

       if ($this->isSearched()) {
                $this->filterByTerms($table, ['hash', 'title', 'url'], true);
       }