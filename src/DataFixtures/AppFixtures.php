<?php

namespace App\DataFixtures;

use App\Entity\patternCollection;
use App\Entity\CrochetPattern;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Member;


class AppFixtures extends Fixture
{
    // définit les noms des collections avec références
    private const COLLECTION_DOUX = 'collection-doudous-tout-doux';
    private const COLLECTION_CROP_TOPS = 'collection-crop-tops-d-ete';
    private const COLLECTION_ECHARPES = 'collection-echarpes-d-hiver';
    private const COLLECTION_BONNET_MITAINES = 'collection-bonnet-et-mitaines';
    private const COLLECTION_DINETTE = 'collection-dinette';
    private const COLLECTION_JOUETS = 'collection-jouets-en-crochet';
    private const COLLECTION_FRUITS_LEGUMES = 'collection-fruits-et-legumes';
    private const COLLECTION_ANIMAUX_FERME = 'collection-animaux-de-la-ferme';
    private const COLLECTION_SACS_ACCESSOIRES = 'collection-sacs-et-accessoires';
    private const COLLECTION_PERSONNAGES_CONTES = 'collection-personnages-de-contes';
    private const COLLECTION_MONSTRES = 'collection-monstres-rigolos';
    private const COLLECTION_DECORATIONS_NOEL = 'collection-decorations-de-noel';
    

    /**
     * Charge les collections.
     */
    
    private function loadPatternCollections(ObjectManager $manager)
    {
        foreach ($this->getPatternCollection() as [$id, $name, $designer, $dateCreated, $totalPatterns, $reference]) {
            $patternCollection = new patternCollection();
            $patternCollection->setName($name);
            $patternCollection->setDesigner($designer);
            $patternCollection->setDateCreated($dateCreated);
            $patternCollection->setTotalPatterns($totalPatterns);
            
            $manager->persist($patternCollection);
            $manager->flush();
            $this->addReference($reference, $patternCollection);
        }
    }
    
    /**
     * Données de collections.
     */
    
    private function getPatternCollection()
    {
        // patternCollection = [id, name, designer, dateCreated, totalPatterns, reference]
        yield [1, 'Doudous tout doux', 'Zelia', new \DateTime('2022-01-01'), 3, self::COLLECTION_DOUX];
        
        yield [2, 'Crop tops d\'été', 'Tricotteuse', new \DateTime('2023-02-01'), 3, self::COLLECTION_CROP_TOPS];
        
        yield [3, 'Écharpes d\'hiver', 'CrochetLover', new \DateTime('2023-03-01'), 3, self::COLLECTION_ECHARPES];
        
        yield [4, 'Bonnet et mitaines', 'LAtelierDeMimosa', new \DateTime('2024-04-01'), 2, self::COLLECTION_BONNET_MITAINES];
        
        yield [5, 'Dinette', 'Clara Gourmande', new \DateTime('2024-05-01'), 4, self::COLLECTION_DINETTE];
        
        yield [6, 'Jouets en crochet', 'Emmajoyeuse', new \DateTime('2024-06-04'), 3, self::COLLECTION_JOUETS];
        
        yield [7, 'Fruits et légumes en crochet', 'Juliette Nature', new \DateTime('2024-07-07'), 3, self::COLLECTION_FRUITS_LEGUMES];
        
        yield [8, 'Animaux de la ferme en crochet', 'LarcheDeNoé', new \DateTime('2024-08-08'), 3, self::COLLECTION_ANIMAUX_FERME];
        
        yield [9, 'Sacs et accessoires', 'Ninaccessoires', new \DateTime('2024-10-01'), 3, self::COLLECTION_SACS_ACCESSOIRES];
        
        yield [10, 'Personnages de contes en crochet', 'Olivia Contes', new \DateTime('2024-10-01'), 3, self::COLLECTION_PERSONNAGES_CONTES];
        
        yield [11, 'Monstres rigolos en crochet', 'Lucas Rigolo', new \DateTime('2024-01-08'), 3, self::COLLECTION_MONSTRES];
        
        yield [12, 'Décorations de Noël en crochet', 'Pauline Fêtes', new \DateTime('2023-12-01'), 3, self::COLLECTION_DECORATIONS_NOEL];
    }
    
    /**
     * Charge les CrochetPatterns.
     */
    
    private function loadCrochetPatterns(ObjectManager $manager)
    {
        foreach ($this->getCrochetPatternsData() as [$reference, $name, $hookSize, $category, $language, $image, $designer]) {
            $crochetPattern = new CrochetPattern();
            $patternCollection = $this->getReference($reference);
            $crochetPattern->setName($name);
            $crochetPattern->setHookSize($hookSize);
            $crochetPattern->setCategory($category);
            $crochetPattern->setLanguage($language);
            $crochetPattern->setImage($image);
            $crochetPattern->setDesigner($designer);
            $crochetPattern->setPatternCollection($patternCollection);
            
            $manager->persist($crochetPattern);
            $manager->flush();
        }
     }

    
        /**
         * Données de CrochetPatterns.
         */
    
    private function getCrochetPatternsData()
    {
        // Pattern = [name, hook size, category, language, image, designer]
        yield [self::COLLECTION_DOUX, 'Lapin Doux', 3.5, 'Jouets', 'Français', ['https://i.pinimg.com/1200x/f0/6c/dc/f06cdc3b0c857f0fd8a9e02936318880.jpg'], 'Zelia'];
        yield [self::COLLECTION_DOUX, 'Ours Câlin', 4.0, 'Jouets', 'Français', ['https://static.wixstatic.com/media/fbacf8_11e5c531d9df41f2bdc941842bdaef4b~mv2.jpg/v1/fill/w_480,h_374,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/fbacf8_11e5c531d9df41f2bdc941842bdaef4b~mv2.jpg'], 'Zelia'];
        yield [self::COLLECTION_DOUX, 'Chien Mignon', 3.0, 'Jouets', 'Français', ['https://d2j6dbq0eux0bg.cloudfront.net/images/25842236/3521431998.webp'], 'Zelia'];
        
        yield [self::COLLECTION_CROP_TOPS, 'Top rouge troué', 5.0, 'Vêtements', 'Français', ['https://i.etsystatic.com/13935122/r/il/2f2801/4212490582/il_fullxfull.4212490582_9bjv.jpg'], 'Tricotteuse'];
        yield [self::COLLECTION_CROP_TOPS, 'Top bariolé', 5.5, 'Vêtements', 'Français', ['https://i.etsystatic.com/17447127/r/il/5e2a3a/3277362806/il_fullxfull.3277362806_noq2.jpg'], 'Tricotteuse'];
        yield [self::COLLECTION_CROP_TOPS, 'Top océan', 6.0, 'Vêtements', 'Français', ['https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQSqhH3wupf3s3rb0WP32fTvkcY3agxhNza9g&s'], 'Tricotteuse'];
        
        yield [self::COLLECTION_ECHARPES, 'Écharpe Arc-en-ciel', 4.5, 'Accessoires', 'Français', ['https://i.etsystatic.com/5894050/r/il/91c573/2965331284/il_570xN.2965331284_958e.jpg'], 'CrochetLover'];
        yield [self::COLLECTION_ECHARPES, 'Écharpe Neige', 4.0, 'Accessoires', 'Français', ['https://i.etsystatic.com/6682151/r/il/40464f/328763750/il_570xN.328763750.jpg'], 'CrochetLover'];
        yield [self::COLLECTION_ECHARPES, 'Écharpe Forêt', 4.0, 'Accessoires', 'Français', ['https://i.etsystatic.com/31848199/r/il/8cd387/5295336399/il_fullxfull.5295336399_hz0p.jpg'], 'CrochetLover'];
        
        yield [self::COLLECTION_BONNET_MITAINES, 'Bonnet Chaud', 4.5, 'Accessoires', 'Français', ['https://m.media-amazon.com/images/I/61W5oCjfDKL._AC_UY1000_.jpg'], 'LAtelierDeMimosa'];
        yield [self::COLLECTION_BONNET_MITAINES, 'Mitaines Douces', 3.5, 'Accessoires', 'Français', ['https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR8xutybilp42-HiojYhFEZZKrhpd-vYjZDHw&s'], 'LAtelierDeMimosa'];
        
        yield [self::COLLECTION_DINETTE, 'Oeuf au plat', 3.0, 'Dinette', 'Français', ['https://i.etsystatic.com/10444606/r/il/d4dd69/4488046765/il_570xN.4488046765_g8l7.jpg'], 'Clara Gourmande'];
        yield [self::COLLECTION_DINETTE, 'Coquillages et crustacés', 3.0, 'Dinette', 'Français', ['https://i.etsystatic.com/21534366/r/il/18fd94/3420671565/il_570xN.3420671565_7p9w.jpg'], 'Clara Gourmande'];
        yield [self::COLLECTION_DINETTE, 'Poivrons', 3.0, 'Dinette', 'Français', ['https://luniversdelalu.com/storage/2024/07/poivron-site-4.jpg'], 'Clara Gourmande'];
        yield [self::COLLECTION_DINETTE, 'Panier de fruits', 3.5, 'Dinette', 'Français', ['https://i.etsystatic.com/33574778/r/il/276562/3717780036/il_570xN.3717780036_hhs8.jpg'], 'Clara Gourmande'];
    }
    
    /**
     * Hasher de mots de passe pour les membres.
     */
    
    
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    /**
     * Génère des données pour la création des membres:
     *      [email, plain text password]
     * @return \\Generator
     */
    
    private function membersGenerator()
    {
        yield ['alizee@localhost','123456'];
        yield ['zelia@localhost','123456'];
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadPatternCollections($manager);
        $this->loadCrochetPatterns($manager);
        
        foreach ($this->membersGenerator() as [$email, $plainPassword]) {
            $user = new Member();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($password);
            
            // compléter ultérieurement:
            // $roles = array();
            // $roles[] = $role;
            // $user->setRoles($roles);
            
            $manager->persist($user);
        }
        $manager->flush();
    }
    
}