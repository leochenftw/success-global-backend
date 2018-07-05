<?php
use SaltedHerring\Debugger;
class DataListExt extends Extension
{
    public function getData()
    {
        $data                       =   [];
        foreach ($this->owner as $item)
        {
            if ($item->hasMethod('getData')) {
                $data[]             =   $item->getData();
            }
        }

        return $data;
    }

    public function Paginate($n, $request)
    {
        if ($n >= $this->owner->count()) {
            return  [
                        'list'      =>  $this->owner->getData(),
                        'next'      =>  null
                    ];
        }

        $paged                      =   new PaginatedList($this->owner, $request);

        $paged->setPageLength($n);

        $list                       =   $paged->getIterator();
        $data                       =   [];

        foreach ($list as $item) {
            $data[]                 =   $item->getData();
        }

        if ($paged->MoreThanOnePage()) {
            if ($paged->NotLastPage()) {
                // $pagination         =   $this->sanitisePagination($paged->NextLink());
                return  [
                            'list'  =>  $data,
                            'next'  =>  $paged->NextLink()
                        ];
            }
        }


        return  [
                    'list'          =>  $data,
                    'next'          =>  null
                ];
    }
}
