<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    public function definition()
    {
        $dishes = [
            [
                'name' => 'Łosoś z komosą ryżową', 
                'description' => 'Delikatny filet z łososia pieczony z ziołami, podawany z komosą ryżową i warzywami sezonowymi. Bogate źródło kwasów omega-3.',
                'price' => 36.90
            ],
            [
                'name' => 'Kurczak w ziołach prowansalskich', 
                'description' => 'Soczysta pierś z kurczaka marynowana w ziołach prowansalskich, podawana z kaszą bulgur i mieszanką warzyw na parze.',
                'price' => 29.90
            ],
            [
                'name' => 'Makaron pełnoziarnisty z warzywami', 
                'description' => 'Makaron pełnoziarnisty z bogatym sosem z pieczonych warzyw, pomidorami cherry i bazylią. Opcja wegetariańska bogata w błonnik.',
                'price' => 26.50
            ],
            [
                'name' => 'Sałatka z quinoa i awokado', 
                'description' => 'Lekka sałatka z quinoa, awokado, pomidorkami koktajlowymi, rukolą i pestkami dyni. Skropiona oliwą z pierwszego tłoczenia.',
                'price' => 28.90
            ],
            [
                'name' => 'Chili con carne fit', 
                'description' => 'Klasyczne chili przygotowane z chudej wołowiny, czerwonej fasoli, kukurydzy i warzyw. Podawane z brązowym ryżem.',
                'price' => 31.90
            ],
            [
                'name' => 'Bowl z tofu i warzywami', 
                'description' => 'Wegański bowl z marynowanym tofu, brązowym ryżem, awokado, marchewką, brokułami i hummusem. Posypany prażonymi ziarnami.',
                'price' => 32.50
            ],
            [
                'name' => 'Indyk z batatami', 
                'description' => 'Delikatne polędwiczki z indyka z puree z batatów, zielonym groszkiem i sosem ziołowym. Bogate w białko i witaminy.',
                'price' => 34.90
            ],
            [
                'name' => 'Omlet proteinowy', 
                'description' => 'Omlet z białek jaj, ze szpinakiem, pomidorami suszonymi i fetą. Idealny na śniadanie, bogaty w białko.',
                'price' => 24.50
            ],
            [
                'name' => 'Pudding chia z owocami', 
                'description' => 'Pudding z nasion chia na mleku roślinnym, z dodatkiem miodu, owoców leśnych i granoli. Pełen antyoksydantów i błonnika.',
                'price' => 19.90
            ],
            [
                'name' => 'Zupa krem z batatów', 
                'description' => 'Aksamitna zupa krem z batatów z dodatkiem mleka kokosowego, kurkumy i prażonych pestek dyni. Rozgrzewająca i sycąca.',
                'price' => 22.90
            ],
        ];
        
        return $dishes[array_rand($dishes)];
    }
}