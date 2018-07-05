<?php use SaltedHerring\Debugger;

class Signup extends Page_Controller
{
    private $extraClassName = '';
    /**
     * Defines methods that can be called directly
     * @var array
     */
    private static $allowed_actions = array(
        'SignupForm',
        'activate'
    );

    public function index($request)
    {
		if ($member = Member::currentUser()) {
			return $this->redirect('/');
		}

		return $this->renderWith(array('Signup', 'Page'));
	}

    public function activate($request) {
		$member_id = $request->getVar('id');
        $this->extraClassName = 'activation';
		$key = $request->getVar('token');
		if ($member = Member::get()->byID($member_id)) {
			if (empty($member->ValidationKey)) {
				$content = '<p>Already activated. You will be redirected in a few seconds...</p>';
			} elseif ($member->ValidationKey == $key) {
				$content = '<h2 class="title is-2">Thanks!</h2><p>Your account has been activated. Your will be redirected in a few seconds...</p>';
				$member->ValidationKey = null;
				$member->write();
				$member->login();
			} else {
				$content = "not match!";
			}
		} else {
			$content = 'No such member';
		}

		return $this->customise(new ArrayData(array('Title' => 'Account Activation', 'Content' => $content)))->renderWith(array('ActivationPage', 'Page'));
	}

    public function SignupForm()
    {
        return new SignupForm($this);
    }

    public function Link($action = NULL) {
		return 'signup';
	}

    public function Title()
    {
        return 'Sign up';
    }

    public function extraBodyClassName()
    {
        return $this->extraClassName;
    }

}
