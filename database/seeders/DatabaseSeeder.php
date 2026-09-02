<?php

namespace Database\Seeders;

use App\Models\Evenement;
use App\Models\Produit;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);

        Service::insert([
            [
                'nom' => 'Création de sites internet',
                'description' => 'Conception et développement de sites vitrines et institutionnels sur mesure.',
                'icone' => 'globe',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nom' => 'Développement web',
                'description' => 'Applications web métier, plateformes et outils internes.',
                'icone' => 'code',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nom' => "Développement d'applications mobiles",
                'description' => 'Applications Android et iOS natives ou multiplateformes.',
                'icone' => 'phone-fill',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nom' => 'Design graphique et web',
                'description' => 'Identité visuelle, maquettes UI/UX et supports de communication.',
                'icone' => 'palette-fill',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nom' => 'Community management',
                'description' => 'Gestion et animation de vos réseaux sociaux.',
                'icone' => 'megaphone-fill',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nom' => 'Maintenance informatique',
                'description' => 'Suivi, dépannage et maintenance de votre parc informatique.',
                'icone' => 'wrench',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nom' => 'Installation des stations météo',
                'description' => 'Déploiement de stations de mesure météorologique connectées.',
                'icone' => 'cloud-fill',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nom' => 'Automatisme et maintenance industrielle',
                'description' => "Solutions d'automatisation et maintenance des équipements industriels.",
                'icone' => 'gear-fill',
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        Produit::insert([
            [
                'nom' => 'Kufuli Smart Lock',
                'description' => 'Sérure connecté avec management simple',
                'site_web' => 'https://www.kufulis.com',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nom' => 'AangaraaPay',
                'description' => 'Api de piement par mobile money : MTN Mobile Money et Orange Money',
                'site_web' => 'https://aangaraa-pay.com',
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        Evenement::insert([
            [
                'nom' => 'Lancement de PialoaTech',
                'description' => "Présentation officielle de l'entreprise et de ses solutions digitales.",
                'periode_debut' => now()->addDays(15),
                'periode_fin' => now()->addDays(15),
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
