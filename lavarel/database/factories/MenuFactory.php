<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    public function definition()
    {
        $mealCategories = ['śniadanie', 'drugie śniadanie', 'obiad', 'podwieczorek', 'kolacja'];
        
        $dishes = [
            // ŚNIADANIA
            [
                'name' => 'Omlet proteinowy', 
                'description' => 'Omlet z białek jaj, ze szpinakiem, pomidorami suszonymi i fetą. Idealny na śniadanie, bogaty w białko.',
                'price' => 24.50,
                'category' => 'śniadanie'
            ],
            [
                'name' => 'Jogurt grecki z granolą', 
                'description' => 'Kremowy jogurt grecki z domową granolą, orzechami i świeżymi owocami sezonowymi. Doskonałe źródło białka na początek dnia.',
                'price' => 18.90,
                'category' => 'śniadanie'
            ],
            [
                'name' => 'Szakszuka fit', 
                'description' => 'Jajka gotowane w aromatycznym sosie pomidorowym z papryką, cebulą i przyprawami. Serwowane z pieczywem pełnoziarnistym.',
                'price' => 26.50,
                'category' => 'śniadanie'
            ],
            
            // DRUGIE ŚNIADANIA
            [
                'name' => 'Pudding chia z owocami', 
                'description' => 'Pudding z nasion chia na mleku roślinnym, z dodatkiem miodu, owoców leśnych i granoli. Pełen antyoksydantów i błonnika.',
                'price' => 19.90,
                'category' => 'drugie śniadanie'
            ],
            [
                'name' => 'Wrap z hummusem i warzywami', 
                'description' => 'Tortilla pełnoziarnista z kremowym hummusem, świeżymi warzywami i kiełkami. Lekka i pożywna przekąska na drugie śniadanie.',
                'price' => 22.50,
                'category' => 'drugie śniadanie'
            ],
            [
                'name' => 'Smoothie bowl proteinowe', 
                'description' => 'Gęsty koktajl ze świeżych owoców i białka serweczkowego, posypany orzechami, nasionami i płatkami kokosowymi.',
                'price' => 23.90,
                'category' => 'drugie śniadanie'
            ],
            
            // OBIADY
            [
                'name' => 'Łosoś z komosą ryżową', 
                'description' => 'Delikatny filet z łososia pieczony z ziołami, podawany z komosą ryżową i warzywami sezonowymi. Bogate źródło kwasów omega-3.',
                'price' => 36.90,
                'category' => 'obiad'
            ],
            [
                'name' => 'Kurczak w ziołach prowansalskich', 
                'description' => 'Soczysta pierś z kurczaka marynowana w ziołach prowansalskich, podawana z kaszą bulgur i mieszanką warzyw na parze.',
                'price' => 29.90,
                'category' => 'obiad'
            ],
            [
                'name' => 'Makaron pełnoziarnisty z warzywami', 
                'description' => 'Makaron pełnoziarnisty z bogatym sosem z pieczonych warzyw, pomidorami cherry i bazylią. Opcja wegetariańska bogata w błonnik.',
                'price' => 26.50,
                'category' => 'obiad'
            ],
            [
                'name' => 'Indyk z batatami', 
                'description' => 'Delikatne polędwiczki z indyka z puree z batatów, zielonym groszkiem i sosem ziołowym. Bogate w białko i witaminy.',
                'price' => 34.90,
                'category' => 'obiad'
            ],
            
            // PODWIECZORKI
            [
                'name' => 'Muffin proteinowy', 
                'description' => 'Puszysty muffin z dodatkiem białka, z kawałkami gorzkiej czekolady i orzechami. Słodka przekąska z obniżoną zawartością cukru.',
                'price' => 16.90,
                'category' => 'podwieczorek'
            ],
            [
                'name' => 'Parfait jogurtowe', 
                'description' => 'Warstwowy deser z jogurtu greckiego, musli i świeżych owoców. Zdrowa alternatywa dla tradycyjnych słodyczy.',
                'price' => 18.50,
                'category' => 'podwieczorek'
            ],
            [
                'name' => 'Energy ball orzechowe', 
                'description' => 'Domowe kulki energetyczne z daktyli, orzechów i nasion. Naturalna słodycz i zastrzyk energii bez dodatku cukru.',
                'price' => 15.90,
                'category' => 'podwieczorek'
            ],
            
            // KOLACJE
            [
                'name' => 'Sałatka z quinoa i awokado', 
                'description' => 'Lekka sałatka z quinoa, awokado, pomidorkami koktajlowymi, rukolą i pestkami dyni. Skropiona oliwą z pierwszego tłoczenia.',
                'price' => 28.90,
                'category' => 'kolacja'
            ],
            [
                'name' => 'Bowl z tofu i warzywami', 
                'description' => 'Wegański bowl z marynowanym tofu, brązowym ryżem, awokado, marchewką, brokułami i hummusem. Posypany prażonymi ziarnami.',
                'price' => 32.50,
                'category' => 'kolacja'
            ],
            [
                'name' => 'Zupa krem z batatów', 
                'description' => 'Aksamitna zupa krem z batatów z dodatkiem mleka kokosowego, kurkumy i prażonych pestek dyni. Rozgrzewająca i sycąca.',
                'price' => 22.90,
                'category' => 'kolacja'
            ],
            [
                'name' => 'Chili con carne fit', 
                'description' => 'Klasyczne chili przygotowane z chudej wołowiny, czerwonej fasoli, kukurydzy i warzyw. Podawane z brązowym ryżem.',
                'price' => 31.90,
                'category' => 'kolacja'
            ],
        ];
        
        return $dishes[array_rand($dishes)];
    }
}