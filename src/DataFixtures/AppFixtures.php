<?php

namespace App\DataFixtures;

use App\Entity\PatternCollection;
use App\Entity\CrochetPattern;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    // defines reference names for instances of PatternCollection
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
    

    public function load(ObjectManager $manager)
    {
        $this->loadPatternCollections($manager);
        $this->loadCrochetPatterns($manager);
    }

    /**
     * Charge les PatternCollections.
     */
    
    private function loadPatternCollections(ObjectManager $manager)
    {
        foreach ($this->getPatternCollectionsData() as [$id, $name, $designer, $dateCreated, $totalPatterns, $reference]) {
            $patternCollection = new PatternCollection();
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
     * Données de PatternCollections.
     */
    
    private function getPatternCollectionsData()
    {
        // PatternCollection = [id, name, designer, dateCreated, totalPatterns, reference]
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
            $crochetPattern->setCollection($patternCollection);
            
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
        yield [self::COLLECTION_DOUX, 'Lapin Doux', 3.5, 'Jouets', 'Français', [''], 'Zelia'];
        yield [self::COLLECTION_DOUX, 'Ours Câlin', 4.0, 'Jouets', 'Français', [''], 'Zelia'];
        yield [self::COLLECTION_DOUX, 'Chien Mignon', 3.0, 'Jouets', 'Français', [''], 'Zelia'];
        
        yield [self::COLLECTION_CROP_TOPS, 'Top rouge troué', 5.0, 'Vêtements', 'Français', [''], 'Tricotteuse'];
        yield [self::COLLECTION_CROP_TOPS, 'Top bariolé', 5.5, 'Vêtements', 'Français', [''], 'Tricotteuse'];
        yield [self::COLLECTION_CROP_TOPS, 'Top océan', 6.0, 'Vêtements', 'Français', [''], 'Tricotteuse'];
        
        yield [self::COLLECTION_ECHARPES, 'Écharpe Arc-en-ciel', 4.5, 'Accessoires', 'Français', [''], 'CrochetLover'];
        yield [self::COLLECTION_ECHARPES, 'Écharpe Neige', 4.0, 'Accessoires', 'Français', [''], 'CrochetLover'];
        yield [self::COLLECTION_ECHARPES, 'Écharpe Forêt', 4.0, 'Accessoires', 'Français', [''], 'CrochetLover'];
        
        yield [self::COLLECTION_BONNET_MITAINES, 'Bonnet Chaud', 4.5, 'Accessoires', 'Français', [''], 'LAtelierDeMimosa'];
        yield [self::COLLECTION_BONNET_MITAINES, 'Mitaines Douces', 3.5, 'Accessoires', 'Français', [''], 'LAtelierDeMimosa'];
        
        yield [self::COLLECTION_DINETTE, 'Assiette', 3.0, 'Dinette', 'Français', [''], 'Clara Gourmande'];
        yield [self::COLLECTION_DINETTE, 'Tasse', 3.0, 'Dinette', 'Français', [''], 'Clara Gourmande'];
        yield [self::COLLECTION_DINETTE, 'Couverts', 3.0, 'Dinette', 'Français', [''], 'Clara Gourmande'];
        yield [self::COLLECTION_DINETTE, 'Panier de fruits', 3.5, 'Dinette', 'Français', [''], 'Clara Gourmande'];
    }
      
    
}
