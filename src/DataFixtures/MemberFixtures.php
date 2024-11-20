<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MemberFixtures extends Fixture
{
    
    public function load(ObjectManager $manager): void
    {
        // 1. On charge les membres
        $this->loadMembers($manager);
        dump ("les membres sont chargés");
        // 2. On charge les collections via AppFixtures.php
        // 3. On charge les patrons via AppFixtures.php
        // 4. On charge les portfolios via AppFixtures.php
        
        $manager->flush();
    }

    // définit les références des membres
    private const MEMBER_ZELIA = 'member-zelia';
    private const MEMBER_ALIZEE = 'member-alizee';
    private const MEMBER_CROCHET_CHIC = 'member-crochet-chic';
    private const MEMBER_LAINEUSE = 'member-laineuse';
    private const MEMBER_FIL_DE_FER = 'member-fil-de-fer';
    private const MEMBER_BOUCLE_DOR = 'member-boucle-dor';
    private const MEMBER_GRANNY_SQUARES = 'member-granny-squares';
    private const MEMBER_TRICOTEUSE_FANTAISIE = 'member-tricoteuse-fantaisie';
    private const MEMBER_FIL_MAGIQUE = 'member-fil-magique';
    private const MEMBER_PELOTE_ROSE = 'member-pelote-rose';
    private const MEMBER_CROCHET_HIPPIE = 'member-crochet-hippie';
    private const MEMBER_TISSAGE_ET_FIL = 'member-tissage-et-fil';
    
    
    /**
     * Charge les membres.
     */
    
    private function loadMembers(ObjectManager $manager)
    {
        foreach ($this->getMembers() as [$reference, $email, $role, $plainPassword]) {
            $user = new Member();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setRoles($role);
            
            $manager->persist($user);
            $manager->flush();
            $this->addReference($reference, $user);
        }
    }
    
    
    /**
     * Données des membres
     */
    
    private function getMembers()
    {
        // Structure: [reference, email, role, plain password]
        yield [self::MEMBER_ZELIA, 'zelia@localhost', ['ROLE_ADMIN'], 'password1'];
        yield [self::MEMBER_ALIZEE, 'alizee@localhost', ['ROLE_USER'], 'password2'];
        yield [self::MEMBER_CROCHET_CHIC, 'crochet.chic@localhost', ['ROLE_USER'], 'password3'];
        yield [self::MEMBER_LAINEUSE, 'laineuse@localhost', ['ROLE_USER'], 'password4'];
        yield [self::MEMBER_FIL_DE_FER, 'fil_de_fer@localhost', ['ROLE_USER'], 'password5'];
        yield [self::MEMBER_BOUCLE_DOR, 'boucle_dor@localhost', ['ROLE_USER'], 'password6'];
        yield [self::MEMBER_GRANNY_SQUARES, 'granny_squares@localhost', ['ROLE_USER'], 'password7'];
        yield [self::MEMBER_TRICOTEUSE_FANTAISIE, 'tricoteuse_fantaisie@localhost', ['ROLE_USER'], 'password8'];
        yield [self::MEMBER_FIL_MAGIQUE, 'fil_magique@localhost', ['ROLE_USER'], 'password9'];
        yield [self::MEMBER_PELOTE_ROSE, 'pelote_rose@localhost', ['ROLE_USER'], 'password10'];
        yield [self::MEMBER_CROCHET_HIPPIE, 'crochet_hippie@localhost', ['ROLE_USER'], 'password11'];
        yield [self::MEMBER_TISSAGE_ET_FIL, 'tissage_et_fil@localhost', ['ROLE_USER'], 'password12'];
        
    }
    
    /**
     * Hasher de mots de passe pour les membres.
     */
    
    
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    
}