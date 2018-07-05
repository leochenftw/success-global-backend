<?php
use SaltedHerring\Debugger;
use SaltedHerring\SaltedCache;
class ControllerAjaxExtension extends DataExtension
{
    public function index()
    {
        $request    =   $this->owner->request;
        $header     =   $this->owner->getResponse();

        if (!Director::isLive()) {
            $header->addHeader('Access-Control-Allow-Origin', '*');
            $header->addHeader('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
            $header->addHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        }

        if ($request->isAjax()) {
            // header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
            // header('Access-Control-Max-Age: 1000');

            $header->addHeader('Content-Type', 'application/json');
            // $header->addHeader('Cache-Control', 'no-transform, public, max-age=300, s-maxage=900');

            return json_encode($this->owner->AjaxResponse());
        }

        return $this->owner->renderWith([$this->owner->ClassName, 'Page']);
    }

    public function AjaxResponse()
    {
        if (Director::isLive()) {
            $data                       =   SaltedCache::read('PageDataCache', 'Base_' . $this->owner->ID);
        }

        if (empty($data)) {

            $nav                        =   [];
            $navigation                 =   MenuSet::get()->filter(['Name' => 'Main'])->first()->MenuItems(); //$this->owner->getMenu(1)->exclude(['ClassName' => 'HomePage']);
            foreach ($navigation as $nav_item)
            {
                $nav[]                  =   $this->getMenuSetData($nav_item);//$this->getNavitemData($nav_item);
            }

            $data                       =   [
                                                'id'            =>  $this->owner->ID,
                                                'url'           =>  $this->owner->Link() == '/home/' ?
                                                                    '/' :
                                                                    $this->owner->Link(),
                                                'title'         =>  $this->owner->Title,
                                                'content'       =>  $this->owner->Content,
                                                'navigation'    =>  $nav,
                                                'breadcrumbs'   =>  $this->owner->getBreadcrumbs(),
                                                'sitename'      =>  SiteConfig::current_site_config()->Title,
                                                'slogan'        =>  SiteConfig::current_site_config()->Tagline,
                                                'footer_slogan' =>  !empty(SiteConfig::current_site_config()->FooterSlogan) ?
                                                                    SiteConfig::current_site_config()->FooterSlogan :
                                                                    SiteConfig::current_site_config()->Tagline,
                                                'csrf'          =>  SecurityToken::getSecurityID()
                                            ];

            $this->AttachContact($data);
            $this->AttachNews($data);

            if (Director::isLive()) {
                SaltedCache::save('PageDataCache', 'Base_' . $this->owner->ID, $data);
            }
        }

        return $data;
    }

    private function getMenuSetData(&$nav_item)
    {
        return  [
                    'title'     =>  $nav_item->MenuTitle,
                    'url'       =>  $nav_item->Link,
                    'scroll_to' =>  $nav_item->ScrollTo,
                    'is_active' =>  false,
                    'tail'      =>  null
                ];
    }

    private function getNavitemData(&$nav_item)
    {
        $data           =   [
                                'title'     =>  $nav_item->MenuTitle,
                                'url'       =>  $nav_item->Link(),
                                'is_active' =>  $nav_item->LinkOrSection() == 'section',
                                'tail'      =>  $nav_item->Children()->exists() ?
                                                [
                                                    'title' =>  $nav_item->Children()->last()->Title,
                                                    'url'   =>  $nav_item->Children()->last()->Link()
                                                ] : null

                            ];

        if ($nav_item->Children()->exists()) {

            $data['children']               =   [];
            $children                       =   $nav_item->Children();

            foreach ($children as $child)
            {
                $data['children'][]         =   $this->getNavitemData($child);
            }
        }

        return $data;
    }

    private function AttachContact(&$data)
    {
        if ($contact = ContactPage::get()->first())
        {
            $data['contact']            =   $contact->getData();
        }
    }

    private function AttachNews(&$data)
    {
        if ($news = NewsLandingPage::get()->first()) {
            $data['news']               =   $news->getData();
        }
    }
}
