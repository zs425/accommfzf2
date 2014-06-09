<?php
namespace Admin\Service;

use Travel\Service\AbstractService;
/**
 * @author n3ziniuka5
 * @property \Zend\Session\SessionManager				$sessionManager
 * @property \Zend\Session\Storage\StorageInterface		$sessionStorage
 */
class AuthService extends AbstractService {

    protected $sessionManager;
    protected $sessionStorage;
    
    public function isLoggedIn() {
        if($this->getSessionStorage()->offsetExists('userId')) {
            if($this->isStillAdmin()) {
                return true;
            }
            else {
                $this->logout();
            }
        }
        return false;
    }
    
    public function isStillAdmin() {
        $dql = "SELECT u FROM Travel\Entity\User u WHERE u.userId = :userId AND u.userRole = 'admin' AND u.userStatus = 'Active'";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('userId', $this->getUserId());
        return $query->getOneOrNullResult();
    }
    
    public function authenticate($username, $password, $rememberMe) {
        $dql = "SELECT partial u.{userId} FROM Travel\Entity\User u WHERE u.username = :username AND u.password = :password AND u.userRole = 'admin' AND u.userStatus = 'Active'";
        $params = array(
            'username' => $username,
            'password' => md5($password),
        );
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameters($params);
        $row = $query->getOneOrNullResult();
        if($row) {
            if($rememberMe) {
                $config = $this->getConfig();                
                $this->getSessionManager()->rememberMe($config['zfcadmin']['remember_me_time']);
            }
            $this->getSessionStorage()->offsetSet('userId', $row->getUserId());
            $this->getSessionManager()->regenerateId();
            return true;
        }
        return false;
    }
    
    public function getUserId() {
        return $this->getSessionStorage()->offsetGet('userId');
    }
    
    public function getLoggedUser() {
    	return $this->getEntityManager()->find('Travel\Entity\User', $this->getUserId());
    }
    
    public function logout() {
        $this->getSessionStorage()->clear();
        $this->getSessionManager()->forgetMe();
        $this->getSessionManager()->regenerateId();
    }
    
    protected function getSessionManager() {
        if(!$this->sessionManager) {
            $this->sessionManager = $this->getServiceManager()->get('Admin\SessionManager');
        }
        return $this->sessionManager;
    }
    
    protected function getSessionStorage() {
        if(!$this->sessionStorage) {
            $this->sessionStorage = $this->getServiceManager()->get('Admin\SessionStorage');
        }
        return $this->sessionStorage;
    }
    
}