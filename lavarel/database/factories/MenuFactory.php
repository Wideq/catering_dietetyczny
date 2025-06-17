<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    public function definition(): array
    {
        $dishes = [

            [
                'name' => 'Owsianka z owocami', 
                'description' => 'Kremowa owsianka na mleku migdałowym z dodatkiem świeżych owoców sezonowych, orzechów i miodu.',
                'price' => 12.90, 
                'category' => 'śniadanie',
                'calories' => 350,
                'protein' => 12.5,
                'carbs' => 55.2,
                'fat' => 8.3,
                'fiber' => 7.1
            ],
            [
                'name' => 'Jajecznica z awokado', 
                'description' => 'Puszista jajecznica z trzech jaj na maśle klarowanym, podawana z plasterkami awokado i pieczywem pełnoziarnistym.',
                'price' => 15.90, 
                'category' => 'śniadanie',
                'calories' => 420,
                'protein' => 18.2,
                'carbs' => 25.1,
                'fat' => 28.5,
                'fiber' => 6.8
            ],
            [
                'name' => 'Szakszuka fit', 
                'description' => 'Jajka gotowane w aromatycznym sosie pomidorowym z papryką, cebulą i przyprawami.',
                'price' => 16.50, 
                'category' => 'śniadanie',
                'calories' => 280,
                'protein' => 15.8,
                'carbs' => 18.3,
                'fat' => 16.2,
                'fiber' => 4.5
            ],
            
            [
                'name' => 'Pudding chia z owocami', 
                'description' => 'Pudding z nasion chia na mleku roślinnym, z dodatkiem miodu, owoców leśnych i granoli.',
                'price' => 11.90, 
                'category' => 'drugie śniadanie',
                'calories' => 240,
                'protein' => 8.2,
                'carbs' => 32.1,
                'fat' => 9.5,
                'fiber' => 12.3
            ],
            [
                'name' => 'Wrap z hummusem', 
                'description' => 'Tortilla pełnoziarnista z kremowym hummusem, świeżymi warzywami i kiełkami.',
                'price' => 13.50, 
                'category' => 'drugie śniadanie',
                'calories' => 320,
                'protein' => 11.8,
                'carbs' => 42.3,
                'fat' => 12.1,
                'fiber' => 8.7
            ],
            [
                'name' => 'Smoothie bowl proteinowe', 
                'description' => 'Gęsty koktajl ze świeżych owoców i białka, posypany orzechami i płatkami kokosowymi.',
                'price' => 14.90, 
                'category' => 'drugie śniadanie',
                'calories' => 380,
                'protein' => 22.4,
                'carbs' => 45.2,
                'fat' => 14.8,
                'fiber' => 9.2
            ],
            
            [
                'name' => 'Łosoś z komosą ryżową', 
                'description' => 'Delikatny filet z łososia pieczony z ziołami, podawany z komosą ryżową i warzywami sezonowymi.',
                'price' => 24.90, 
                'category' => 'obiad',
                'calories' => 520,
                'protein' => 32.5,
                'carbs' => 35.8,
                'fat' => 24.2,
                'fiber' => 5.3
            ],
            [
                'name' => 'Kurczak w ziołach', 
                'description' => 'Soczysta pierś z kurczaka marynowana w ziołach prowansalskich z kaszą bulgur.',
                'price' => 19.90, 
                'category' => 'obiad',
                'calories' => 460,
                'protein' => 38.2,
                'carbs' => 28.5,
                'fat' => 18.3,
                'fiber' => 4.8
            ],
            [
                'name' => 'Makaron z warzywami', 
                'description' => 'Makaron pełnoziarnisty z bogatym sosem z pieczonych warzyw, pomidorami i bazylią.',
                'price' => 17.50, 
                'category' => 'obiad',
                'calories' => 420,
                'protein' => 14.2,
                'carbs' => 68.5,
                'fat' => 11.8,
                'fiber' => 12.1
            ],
            [
                'name' => 'Indyk z batatami', 
                'description' => 'Delikatne polędwiczki z indyka z puree z batatów, zielonym groszkiem i sosem ziołowym.',
                'price' => 22.90, 
                'category' => 'obiad',
                'calories' => 485,
                'protein' => 35.8,
                'carbs' => 42.3,
                'fat' => 16.5,
                'fiber' => 6.2
            ],
            
            [
                'name' => 'Muffin proteinowy', 
                'description' => 'Puszysty muffin z dodatkiem białka, z kawałkami gorzkiej czekolady i orzechami.',
                'price' => 8.90, 
                'category' => 'podwieczorek',
                'calories' => 220,
                'protein' => 15.2,
                'carbs' => 18.5,
                'fat' => 9.8,
                'fiber' => 3.2
            ],
            [
                'name' => 'Parfait jogurtowe', 
                'description' => 'Warstwowy deser z jogurtu greckiego, musli i świeżych owoców.',
                'price' => 9.50, 
                'category' => 'podwieczorek',
                'calories' => 190,
                'protein' => 12.8,
                'carbs' => 22.1,
                'fat' => 6.5,
                'fiber' => 4.3
            ],
            [
                'name' => 'Energy ball orzechowe', 
                'description' => 'Domowe kulki energetyczne z daktyli, orzechów i nasion. Naturalna słodycz bez cukru.',
                'price' => 7.90, 
                'category' => 'podwieczorek',
                'calories' => 180,
                'protein' => 6.8,
                'carbs' => 15.2,
                'fat' => 11.5,
                'fiber' => 5.1
            ],
            
            [
                'name' => 'Sałatka z quinoa', 
                'description' => 'Lekka sałatka z quinoa, awokado, pomidorkami koktajlowymi, rukolą i pestkami dyni.',
                'price' => 18.90, 
                'category' => 'kolacja',
                'calories' => 380,
                'protein' => 12.5,
                'carbs' => 35.2,
                'fat' => 22.8,
                'fiber' => 8.5
            ],
            [
                'name' => 'Bowl z tofu', 
                'description' => 'Wegański bowl z marynowanym tofu, brązowym ryżem, awokado i hummusem.',
                'price' => 21.50, 
                'category' => 'kolacja',
                'calories' => 420,
                'protein' => 18.2,
                'carbs' => 45.8,
                'fat' => 18.5,
                'fiber' => 9.8
            ],
            [
                'name' => 'Zupa krem z batatów', 
                'description' => 'Aksamitna zupa krem z batatów z dodatkiem mleka kokosowego i prażonych pestek dyni.',
                'price' => 14.90, 
                'category' => 'kolacja',
                'calories' => 280,
                'protein' => 6.8,
                'carbs' => 38.5,
                'fat' => 12.2,
                'fiber' => 7.3
            ],
            [
                'name' => 'Chili con carne fit', 
                'description' => 'Klasyczne chili z chudej wołowiny, czerwonej fasoli, kukurydzy i warzyw z brązowym ryżem.',
                'price' => 20.90, 
                'category' => 'kolacja',
                'calories' => 450,
                'protein' => 28.5,
                'carbs' => 42.3,
                'fat' => 16.8,
                'fiber' => 11.2
            ],
        ];
        
        return $dishes[array_rand($dishes)];
    }
}