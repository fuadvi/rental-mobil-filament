<?php

namespace App\Filters;

use Closure;

class SearchByTitle
{
   public function handle($query, Closure $next)
   {
      if(request()->has('search_by_title'))
      {
        $keyword = request()->input('search_by_title');

        return $next($query)->whereRaw("title REGEXP ?", [$keyword]);
      }

      return $next($query);
   }
}




