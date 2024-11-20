<?php

namespace App\DataFixtures;

use App\Entity\patternCollection;
use App\Entity\CrochetPattern;
use App\Entity\Portfolio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;



class AppFixtures extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager): void
    {
        // 1. On charge les membres via MemberFixtures.php
        // 2. On charge les collections
        $this->loadPatternCollections($manager);
        dump("les collections sont chargées");
        // 3. On charge les patrons
        $this->loadCrochetPatterns($manager);
        dump ("les patrons sont chargés");
        // 4. On charge les portfolios
        $this->loadPortfolios($manager);
        dump ("les portfolios sont chargés");
        
        $manager->flush();
    }
    
    public function getDependencies(): array
    {
        return [
            MemberFixtures::class, // AppFixtures dépend de MemberFixtures car les portfolios nécessitent des membres
        ];
    }
    
    
    // définit les références des noms des collections
    private const COLLECTION_DOUX = 'collection-doudous-tout-doux';
    private const COLLECTION_CROP_TOPS = 'collection-crop-tops-d-ete';
    private const COLLECTION_CROCHET_CHIC = 'collection-chic-crochetes';
    private const COLLECTION_LAINEUSE = 'collection-laine-en-folie';
    private const COLLECTION_FIL_DE_FER = 'collection-les-fils-de-fer';
    private const COLLECTION_BOUCLE_DOR = 'collection-boucles-dor-et-crochet';
    private const COLLECTION_GRANNY_SQUARES = 'collection-granny-squares-mania';
    private const COLLECTION_TRICOTEUSE_FANTAISIE = 'collection-tricots-de-reve';
    private const COLLECTION_FIL_MAGIQUE = 'collection-fil-magique-et-delices';
    private const COLLECTION_PELOTE_ROSE = 'collection-la-pelote-rose';
    private const COLLECTION_CROCHET_HIPPIE = 'collection-crochet-boheme';
    private const COLLECTION_TISSAGE_ET_FIL = 'collection-tissage-et-fils-magiques';

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
    
    
    //définit les références des noms de patrons de crochet
    private const PATTERN_LAPIN_DOUX = 'pattern-lapin-doux';
    private const PATTERN_OURS_CÂLIN = 'pattern-ours-calin';
    
    private const PATTERN_TOP_ROUGE_TROUE = 'pattern-top-rouge-troue';
    private const PATTERN_TOP_BARIOLE = 'pattern-top-bariole';
          
    // Définit les références des noms des portfolios
    private const PORTFOLIO_DOUX_ZELIA = 'portfolio-doux-zelia';
    private const PORTFOLIO_ETE_ALIZEE = 'portfolio-ete-alizee';
    
    
    /**
     * Charge les collections.
     */
    
    private function loadPatternCollections(ObjectManager $manager)
    {
        foreach ($this->getPatternCollection() as [$reference, $name, $dateCreated, $totalPatterns, $memberReference]) {
            $patternCollection = new PatternCollection();
            $patternCollection->setName($name);
            $patternCollection->setDateCreated($dateCreated);
            $patternCollection->setTotalPatterns($totalPatterns);
            
            // Récupérer le membre auquel la collection appartient
            $member = $this->getReference($memberReference);
            
            // Assigner le membre à la collection
            $patternCollection->setDesigner($member);
            
            // Assigner la collection à l'utilisateur via la relation inverse (si nécessaire)
            $member->setPatternCollection($patternCollection);
            
            // Persist la collection de patrons
            $manager->persist($patternCollection);
            $manager->flush();
            
            // Ajouter la référence pour pouvoir y accéder plus tard dans d'autres fixtures
            $this->addReference($reference, $patternCollection);
        }
    }
    
    
    /**
     * Données de collections.
     */
    
    private function getPatternCollection()
    {
        // patternCollection = [reference, name, dateCreated, totalPatterns, MemberReference]
        yield [self::COLLECTION_DOUX, 'Doudous tout doux', new \DateTime('2022-01-01'), 3, self::MEMBER_ZELIA];
        yield [self::COLLECTION_CROP_TOPS, 'Crop tops d\'été', new \DateTime('2023-02-01'), 3, self::MEMBER_ALIZEE];
        yield [self::COLLECTION_CROCHET_CHIC, 'Chic Crochetés', new \DateTime('2021-11-15'), 5, self::MEMBER_CROCHET_CHIC];
        yield [self::COLLECTION_LAINEUSE, 'Laine en Folie', new \DateTime('2022-03-25'), 7, self::MEMBER_LAINEUSE];
        yield [self::COLLECTION_FIL_DE_FER, 'Les fils de fer', new \DateTime('2022-06-10'), 4, self::MEMBER_FIL_DE_FER];
        yield [self::COLLECTION_BOUCLE_DOR, 'Boucles d\'or et crochet', new \DateTime('2022-08-30'), 6, self::MEMBER_BOUCLE_DOR];
        yield [self::COLLECTION_GRANNY_SQUARES, 'Granny Squares Mania', new \DateTime('2023-01-10'), 10, self::MEMBER_GRANNY_SQUARES];
        yield [self::COLLECTION_TRICOTEUSE_FANTAISIE, 'Tricots de rêve', new \DateTime('2023-04-15'), 8, self::MEMBER_TRICOTEUSE_FANTAISIE];
        yield [self::COLLECTION_FIL_MAGIQUE, 'Fil Magique et Délices', new \DateTime('2023-07-20'), 3, self::MEMBER_FIL_MAGIQUE];
        yield [self::COLLECTION_PELOTE_ROSE, 'La Pelote Rose', new \DateTime('2023-09-05'), 9, self::MEMBER_PELOTE_ROSE];
        yield [self::COLLECTION_CROCHET_HIPPIE, 'Crochet Bohème', new \DateTime('2024-01-18'), 12, self::MEMBER_CROCHET_HIPPIE];
        yield [self::COLLECTION_TISSAGE_ET_FIL, 'Tissage et Fils Magiques', new \DateTime('2024-04-02'), 15, self::MEMBER_TISSAGE_ET_FIL];
    }
 
    
    /**
     * Charge les CrochetPatterns.
     */
    
    private function loadCrochetPatterns(ObjectManager $manager)
    {
        foreach ($this->getCrochetPatterns() as [$reference, $name, $hookSize, $category, $language, $image, $collectionReference]) {
            $crochetPattern = new CrochetPattern();
            
            $crochetPattern->setName($name);
            $crochetPattern->setHookSize($hookSize);
            $crochetPattern->setCategory($category);
            $crochetPattern->setLanguage($language);
            $crochetPattern->setImage($image);
            
            $collection = $this->getReference($collectionReference);
            $crochetPattern->setPatternCollection($collection);
                        
            $manager->persist($crochetPattern);
            $manager->flush();
            $this->addReference($reference, $crochetPattern);
        }
    }
    
    
    /**
     * Données de CrochetPatterns.
     */
    
    private function getCrochetPatterns()
    {
        // Pattern = [reference, name, hook size, category, language, image, collectionReference]
        yield [self::PATTERN_LAPIN_DOUX, 'Lapin Doux', 3.5, 'Jouets', 'Français', ['https://i.pinimg.com/1200x/f0/6c/dc/f06cdc3b0c857f0fd8a9e02936318880.jpg'], self::COLLECTION_DOUX];
        yield [self::PATTERN_OURS_CÂLIN, 'Ours Câlin', 4.0, 'Jouets', 'Français', ['https://static.wixstatic.com/media/fbacf8_11e5c531d9df41f2bdc941842bdaef4b~mv2.jpg/v1/fill/w_480,h_374,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/fbacf8_11e5c531d9df41f2bdc941842bdaef4b~mv2.jpg'], self::COLLECTION_DOUX];
        
        yield [self::PATTERN_TOP_ROUGE_TROUE, 'Top rouge troué', 5.0, 'Vêtements', 'Français', ['https://i.etsystatic.com/13935122/r/il/2f2801/4212490582/il_fullxfull.4212490582_9bjv.jpg'], self::COLLECTION_CROP_TOPS];
        yield [self::PATTERN_TOP_BARIOLE, 'Top bariolé', 5.5, 'Vêtements', 'Français', ['https://i.etsystatic.com/17447127/r/il/5e2a3a/3277362806/il_fullxfull.3277362806_noq2.jpg'], self::COLLECTION_CROP_TOPS];
        
   }
    
    
    
    /**
     * Charge les Portfolios.
     */
    private function loadPortfolios(ObjectManager $manager)
    {
        foreach ($this->getPortfolios() as [$reference, $name, $dateCreated, $totalPatterns, $memberReference, $patternsReference]) {
            $portfolio = new Portfolio();

            $portfolio->setName($name);
            $portfolio->setDateCreated($dateCreated);
            $portfolio->setTotalPatterns($totalPatterns);
            
            $member = $this->getReference($memberReference);
            $portfolio->setMember($member);
            $member->addPortfolio($portfolio);
            
            foreach ($patternsReference as $patternRef) {
                $pattern = $this->getReference($patternRef);
                $portfolio->addPattern($pattern);
            }
            
            $manager->persist($portfolio);
            $manager->flush();
            $this->addReference($reference, $portfolio);
        }
    }
    
    /**
     * Données des Portfolios.
     */
    private function getPortfolios()
    {
        // Portfolio = [reference, name, dateCreated, totalPatterns, memberReference, patternsReference]
        yield [self::PORTFOLIO_DOUX_ZELIA, 'Portfolio Doux Zélia', new \DateTime('2024-02-01'), 2, self::MEMBER_ZELIA, [self::PATTERN_LAPIN_DOUX, self::PATTERN_OURS_CÂLIN]];
        yield [self::PORTFOLIO_ETE_ALIZEE, 'Portfolio Été Alizée', new \DateTime('2023-02-01'), 2, self::MEMBER_ALIZEE, [self::PATTERN_TOP_ROUGE_TROUE, self::PATTERN_TOP_BARIOLE]];
    }
    
}