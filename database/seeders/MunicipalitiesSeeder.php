<?php

namespace Database\Seeders;

use App\Models\Municipality;
use Illuminate\Database\Seeder;

class MunicipalitiesSeeder extends Seeder {
  public function run() {
    $items = [
      [
        'name' => 'AGUASCALIENTES',
        'state_id' => 1
      ],
      [
        'name' => 'ASIENTOS',
        'state_id' => 1
      ],
      [
        'name' => 'CALVILLO',
        'state_id' => 1
      ],
      [
        'name' => 'COSÍO',
        'state_id' => 1
      ],
      [
        'name' => 'JESÚS MARÍA',
        'state_id' => 1
      ],
      [
        'name' => 'PABELLÓN DE ARTEAGA',
        'state_id' => 1
      ],
      [
        'name' => 'RINCÓN DE ROMOS',
        'state_id' => 1
      ],
      [
        'name' => 'SAN JOSÉ DE GRACIA',
        'state_id' => 1
      ],
      [
        'name' => 'TEPEZALÁ',
        'state_id' => 1
      ],
      [
        'name' => 'EL LLANO',
        'state_id' => 1
      ],
      [
        'name' => 'SAN FRANCISCO DE LOS ROMO',
        'state_id' => 1
      ],
      [
        'name' => 'ENSENADA',
        'state_id' => 2
      ],
      [
        'name' => 'MEXICALI',
        'state_id' => 2
      ],
      [
        'name' => 'TECATE',
        'state_id' => 2
      ],
      [
        'name' => 'TIJUANA',
        'state_id' => 2
      ],
      [
        'name' => 'PLAYAS DE ROSARITO',
        'state_id' => 2
      ],
      [
        'name' => 'SAN QUINTÍN',
        'state_id' => 2
      ],
      [
        'name' => 'COMONDÚ',
        'state_id' => 3
      ],
      [
        'name' => 'MULEGÉ',
        'state_id' => 3
      ],
      [
        'name' => 'LA PAZ',
        'state_id' => 3
      ],
      [
        'name' => 'LOS CABOS',
        'state_id' => 3
      ],
      [
        'name' => 'LORETO',
        'state_id' => 3
      ],
      [
        'name' => 'CALKINÍ',
        'state_id' => 4
      ],
      [
        'name' => 'CAMPECHE',
        'state_id' => 4
      ],
      [
        'name' => 'CARMEN',
        'state_id' => 4
      ],
      [
        'name' => 'CHAMPOTÓN',
        'state_id' => 4
      ],
      [
        'name' => 'HECELCHAKÁN',
        'state_id' => 4
      ],
      [
        'name' => 'HOPELCHÉN',
        'state_id' => 4
      ],
      [
        'name' => 'PALIZADA',
        'state_id' => 4
      ],
      [
        'name' => 'TENABO',
        'state_id' => 4
      ],
      [
        'name' => 'ESCÁRCEGA',
        'state_id' => 4
      ],
      [
        'name' => 'CALAKMUL',
        'state_id' => 4
      ],
      [
        'name' => 'CANDELARIA',
        'state_id' => 4
      ],
      [
        'name' => 'SEYBAPLAYA',
        'state_id' => 4
      ],
      [
        'name' => 'ABASOLO',
        'state_id' => 5
      ],
      [
        'name' => 'ACUÑA',
        'state_id' => 5
      ],
      [
        'name' => 'ALLENDE',
        'state_id' => 5
      ],
      [
        'name' => 'ARTEAGA',
        'state_id' => 5
      ],
      [
        'name' => 'CANDELA',
        'state_id' => 5
      ],
      [
        'name' => 'CASTAÑOS',
        'state_id' => 5
      ],
      [
        'name' => 'CUATRO CIÉNEGAS',
        'state_id' => 5
      ],
      [
        'name' => 'ESCOBEDO',
        'state_id' => 5
      ],
      [
        'name' => 'FRANCISCO I. MADERO',
        'state_id' => 5
      ],
      [
        'name' => 'FRONTERA',
        'state_id' => 5
      ],
      [
        'name' => 'GENERAL CEPEDA',
        'state_id' => 5
      ],
      [
        'name' => 'GUERRERO',
        'state_id' => 5
      ],
      [
        'name' => 'HIDALGO',
        'state_id' => 5
      ],
      [
        'name' => 'JIMÉNEZ',
        'state_id' => 5
      ],
      [
        'name' => 'JUÁREZ',
        'state_id' => 5
      ],
      [
        'name' => 'LAMADRID',
        'state_id' => 5
      ],
      [
        'name' => 'MATAMOROS',
        'state_id' => 5
      ],
      [
        'name' => 'MONCLOVA',
        'state_id' => 5
      ],
      [
        'name' => 'MORELOS',
        'state_id' => 5
      ],
      [
        'name' => 'MÚZQUIZ',
        'state_id' => 5
      ],
      [
        'name' => 'NADADORES',
        'state_id' => 5
      ],
      [
        'name' => 'NAVA',
        'state_id' => 5
      ],
      [
        'name' => 'OCAMPO',
        'state_id' => 5
      ],
      [
        'name' => 'PARRAS',
        'state_id' => 5
      ],
      [
        'name' => 'PIEDRAS NEGRAS',
        'state_id' => 5
      ],
      [
        'name' => 'PROGRESO',
        'state_id' => 5
      ],
      [
        'name' => 'RAMOS ARIZPE',
        'state_id' => 5
      ],
      [
        'name' => 'SABINAS',
        'state_id' => 5
      ],
      [
        'name' => 'SACRAMENTO',
        'state_id' => 5
      ],
      [
        'name' => 'SALTILLO',
        'state_id' => 5
      ],
      [
        'name' => 'SAN BUENAVENTURA',
        'state_id' => 5
      ],
      [
        'name' => 'SAN JUAN DE SABINAS',
        'state_id' => 5
      ],
      [
        'name' => 'SAN PEDRO',
        'state_id' => 5
      ],
      [
        'name' => 'SIERRA MOJADA',
        'state_id' => 5
      ],
      [
        'name' => 'TORREÓN',
        'state_id' => 5
      ],
      [
        'name' => 'VIESCA',
        'state_id' => 5
      ],
      [
        'name' => 'VILLA UNIÓN',
        'state_id' => 5
      ],
      [
        'name' => 'ZARAGOZA',
        'state_id' => 5
      ],
      [
        'name' => 'ARMERÍA',
        'state_id' => 6
      ],
      [
        'name' => 'COLIMA',
        'state_id' => 6
      ],
      [
        'name' => 'COMALA',
        'state_id' => 6
      ],
      [
        'name' => 'COQUIMATLÁN',
        'state_id' => 6
      ],
      [
        'name' => 'CUAUHTÉMOC',
        'state_id' => 6
      ],
      [
        'name' => 'IXTLAHUACÁN',
        'state_id' => 6
      ],
      [
        'name' => 'MANZANILLO',
        'state_id' => 6
      ],
      [
        'name' => 'MINATITLÁN',
        'state_id' => 6
      ],
      [
        'name' => 'TECOMÁN',
        'state_id' => 6
      ],
      [
        'name' => 'VILLA DE ÁLVAREZ',
        'state_id' => 6
      ],
      [
        'name' => 'ACACOYAGUA',
        'state_id' => 7
      ],
      [
        'name' => 'ACALA',
        'state_id' => 7
      ],
      [
        'name' => 'ACAPETAHUA',
        'state_id' => 7
      ],
      [
        'name' => 'ALTAMIRANO',
        'state_id' => 7
      ],
      [
        'name' => 'AMATÁN',
        'state_id' => 7
      ],
      [
        'name' => 'AMATENANGO DE LA FRONTERA',
        'state_id' => 7
      ],
      [
        'name' => 'AMATENANGO DEL VALLE',
        'state_id' => 7
      ],
      [
        'name' => 'ÁNGEL ALBINO CORZO',
        'state_id' => 7
      ],
      [
        'name' => 'ARRIAGA',
        'state_id' => 7
      ],
      [
        'name' => 'BEJUCAL DE OCAMPO',
        'state_id' => 7
      ],
      [
        'name' => 'BELLA VISTA',
        'state_id' => 7
      ],
      [
        'name' => 'BERRIOZÁBAL',
        'state_id' => 7
      ],
      [
        'name' => 'BOCHIL',
        'state_id' => 7
      ],
      [
        'name' => 'EL BOSQUE',
        'state_id' => 7
      ],
      [
        'name' => 'CACAHOATÁN',
        'state_id' => 7
      ],
      [
        'name' => 'CATAZAJÁ',
        'state_id' => 7
      ],
      [
        'name' => 'CINTALAPA',
        'state_id' => 7
      ],
      [
        'name' => 'COAPILLA',
        'state_id' => 7
      ],
      [
        'name' => 'COMITÁN DE DOMÍNGUEZ',
        'state_id' => 7
      ],
      [
        'name' => 'LA CONCORDIA',
        'state_id' => 7
      ],
      [
        'name' => 'COPAINALÁ',
        'state_id' => 7
      ],
      [
        'name' => 'CHALCHIHUITÁN',
        'state_id' => 7
      ],
      [
        'name' => 'CHAMULA',
        'state_id' => 7
      ],
      [
        'name' => 'CHANAL',
        'state_id' => 7
      ],
      [
        'name' => 'CHAPULTENANGO',
        'state_id' => 7
      ],
      [
        'name' => 'CHENALHÓ',
        'state_id' => 7
      ],
      [
        'name' => 'CHIAPA DE CORZO',
        'state_id' => 7
      ],
      [
        'name' => 'CHIAPILLA',
        'state_id' => 7
      ],
      [
        'name' => 'CHICOASÉN',
        'state_id' => 7
      ],
      [
        'name' => 'CHICOMUSELO',
        'state_id' => 7
      ],
      [
        'name' => 'CHILÓN',
        'state_id' => 7
      ],
      [
        'name' => 'ESCUINTLA',
        'state_id' => 7
      ],
      [
        'name' => 'FRANCISCO LEÓN',
        'state_id' => 7
      ],
      [
        'name' => 'FRONTERA COMALAPA',
        'state_id' => 7
      ],
      [
        'name' => 'FRONTERA HIDALGO',
        'state_id' => 7
      ],
      [
        'name' => 'LA GRANDEZA',
        'state_id' => 7
      ],
      [
        'name' => 'HUEHUETÁN',
        'state_id' => 7
      ],
      [
        'name' => 'HUIXTÁN',
        'state_id' => 7
      ],
      [
        'name' => 'HUITIUPÁN',
        'state_id' => 7
      ],
      [
        'name' => 'HUIXTLA',
        'state_id' => 7
      ],
      [
        'name' => 'LA INDEPENDENCIA',
        'state_id' => 7
      ],
      [
        'name' => 'IXHUATÁN',
        'state_id' => 7
      ],
      [
        'name' => 'IXTACOMITÁN',
        'state_id' => 7
      ],
      [
        'name' => 'IXTAPA',
        'state_id' => 7
      ],
      [
        'name' => 'IXTAPANGAJOYA',
        'state_id' => 7
      ],
      [
        'name' => 'JIQUIPILAS',
        'state_id' => 7
      ],
      [
        'name' => 'JITOTOL',
        'state_id' => 7
      ],
      [
        'name' => 'JUÁREZ',
        'state_id' => 7
      ],
      [
        'name' => 'LARRÁINZAR',
        'state_id' => 7
      ],
      [
        'name' => 'LA LIBERTAD',
        'state_id' => 7
      ],
      [
        'name' => 'MAPASTEPEC',
        'state_id' => 7
      ],
      [
        'name' => 'LAS MARGARITAS',
        'state_id' => 7
      ],
      [
        'name' => 'MAZAPA DE MADERO',
        'state_id' => 7
      ],
      [
        'name' => 'MAZATÁN',
        'state_id' => 7
      ],
      [
        'name' => 'METAPA',
        'state_id' => 7
      ],
      [
        'name' => 'MITONTIC',
        'state_id' => 7
      ],
      [
        'name' => 'MOTOZINTLA',
        'state_id' => 7
      ],
      [
        'name' => 'NICOLÁS RUÍZ',
        'state_id' => 7
      ],
      [
        'name' => 'OCOSINGO',
        'state_id' => 7
      ],
      [
        'name' => 'OCOTEPEC',
        'state_id' => 7
      ],
      [
        'name' => 'OCOZOCOAUTLA DE ESPINOSA',
        'state_id' => 7
      ],
      [
        'name' => 'OSTUACÁN',
        'state_id' => 7
      ],
      [
        'name' => 'OSUMACINTA',
        'state_id' => 7
      ],
      [
        'name' => 'OXCHUC',
        'state_id' => 7
      ],
      [
        'name' => 'PALENQUE',
        'state_id' => 7
      ],
      [
        'name' => 'PANTELHÓ',
        'state_id' => 7
      ],
      [
        'name' => 'PANTEPEC',
        'state_id' => 7
      ],
      [
        'name' => 'PICHUCALCO',
        'state_id' => 7
      ],
      [
        'name' => 'PIJIJIAPAN',
        'state_id' => 7
      ],
      [
        'name' => 'EL PORVENIR',
        'state_id' => 7
      ],
      [
        'name' => 'VILLA COMALTITLÁN',
        'state_id' => 7
      ],
      [
        'name' => 'PUEBLO NUEVO SOLISTAHUACÁN',
        'state_id' => 7
      ],
      [
        'name' => 'RAYÓN',
        'state_id' => 7
      ],
      [
        'name' => 'REFORMA',
        'state_id' => 7
      ],
      [
        'name' => 'LAS ROSAS',
        'state_id' => 7
      ],
      [
        'name' => 'SABANILLA',
        'state_id' => 7
      ],
      [
        'name' => 'SALTO DE AGUA',
        'state_id' => 7
      ],
      [
        'name' => 'SAN CRISTÓBAL DE LAS CASAS',
        'state_id' => 7
      ],
      [
        'name' => 'SAN FERNANDO',
        'state_id' => 7
      ],
      [
        'name' => 'SILTEPEC',
        'state_id' => 7
      ],
      [
        'name' => 'SIMOJOVEL',
        'state_id' => 7
      ],
      [
        'name' => 'SITALÁ',
        'state_id' => 7
      ],
      [
        'name' => 'SOCOLTENANGO',
        'state_id' => 7
      ],
      [
        'name' => 'SOLOSUCHIAPA',
        'state_id' => 7
      ],
      [
        'name' => 'SOYALÓ',
        'state_id' => 7
      ],
      [
        'name' => 'SUCHIAPA',
        'state_id' => 7
      ],
      [
        'name' => 'SUCHIATE',
        'state_id' => 7
      ],
      [
        'name' => 'SUNUAPA',
        'state_id' => 7
      ],
      [
        'name' => 'TAPACHULA',
        'state_id' => 7
      ],
      [
        'name' => 'TAPALAPA',
        'state_id' => 7
      ],
      [
        'name' => 'TAPILULA',
        'state_id' => 7
      ],
      [
        'name' => 'TECPATÁN',
        'state_id' => 7
      ],
      [
        'name' => 'TENEJAPA',
        'state_id' => 7
      ],
      [
        'name' => 'TEOPISCA',
        'state_id' => 7
      ],
      [
        'name' => 'TILA',
        'state_id' => 7
      ],
      [
        'name' => 'TONALÁ',
        'state_id' => 7
      ],
      [
        'name' => 'TOTOLAPA',
        'state_id' => 7
      ],
      [
        'name' => 'LA TRINITARIA',
        'state_id' => 7
      ],
      [
        'name' => 'TUMBALÁ',
        'state_id' => 7
      ],
      [
        'name' => 'TUXTLA GUTIÉRREZ',
        'state_id' => 7
      ],
      [
        'name' => 'TUXTLA CHICO',
        'state_id' => 7
      ],
      [
        'name' => 'TUZANTÁN',
        'state_id' => 7
      ],
      [
        'name' => 'TZIMOL',
        'state_id' => 7
      ],
      [
        'name' => 'UNIÓN JUÁREZ',
        'state_id' => 7
      ],
      [
        'name' => 'VENUSTIANO CARRANZA',
        'state_id' => 7
      ],
      [
        'name' => 'VILLA CORZO',
        'state_id' => 7
      ],
      [
        'name' => 'VILLAFLORES',
        'state_id' => 7
      ],
      [
        'name' => 'YAJALÓN',
        'state_id' => 7
      ],
      [
        'name' => 'SAN LUCAS',
        'state_id' => 7
      ],
      [
        'name' => 'ZINACANTÁN',
        'state_id' => 7
      ],
      [
        'name' => 'SAN JUAN CANCUC',
        'state_id' => 7
      ],
      [
        'name' => 'ALDAMA',
        'state_id' => 7
      ],
      [
        'name' => 'BENEMÉRITO DE LAS AMÉRICAS',
        'state_id' => 7
      ],
      [
        'name' => 'MARAVILLA TENEJAPA',
        'state_id' => 7
      ],
      [
        'name' => 'MARQUÉS DE COMILLAS',
        'state_id' => 7
      ],
      [
        'name' => 'MONTECRISTO DE GUERRERO',
        'state_id' => 7
      ],
      [
        'name' => 'SAN ANDRÉS DURAZNAL',
        'state_id' => 7
      ],
      [
        'name' => 'SANTIAGO EL PINAR',
        'state_id' => 7
      ],
      [
        'name' => 'CAPITÁN LUIS ÁNGEL VIDAL',
        'state_id' => 7
      ],
      [
        'name' => 'RINCÓN CHAMULA SAN PEDRO',
        'state_id' => 7
      ],
      [
        'name' => 'EL PARRAL',
        'state_id' => 7
      ],
      [
        'name' => 'EMILIANO ZAPATA',
        'state_id' => 7
      ],
      [
        'name' => 'MEZCALAPA',
        'state_id' => 7
      ],
      [
        'name' => 'HONDURAS DE LA SIERRA',
        'state_id' => 7
      ],
      [
        'name' => 'AHUMADA',
        'state_id' => 8
      ],
      [
        'name' => 'ALDAMA',
        'state_id' => 8
      ],
      [
        'name' => 'ALLENDE',
        'state_id' => 8
      ],
      [
        'name' => 'AQUILES SERDÁN',
        'state_id' => 8
      ],
      [
        'name' => 'ASCENSIÓN',
        'state_id' => 8
      ],
      [
        'name' => 'BACHÍNIVA',
        'state_id' => 8
      ],
      [
        'name' => 'BALLEZA',
        'state_id' => 8
      ],
      [
        'name' => 'BATOPILAS DE MANUEL GÓMEZ MORÍN',
        'state_id' => 8
      ],
      [
        'name' => 'BOCOYNA',
        'state_id' => 8
      ],
      [
        'name' => 'BUENAVENTURA',
        'state_id' => 8
      ],
      [
        'name' => 'CAMARGO',
        'state_id' => 8
      ],
      [
        'name' => 'CARICHÍ',
        'state_id' => 8
      ],
      [
        'name' => 'CASAS GRANDES',
        'state_id' => 8
      ],
      [
        'name' => 'CORONADO',
        'state_id' => 8
      ],
      [
        'name' => 'COYAME DEL SOTOL',
        'state_id' => 8
      ],
      [
        'name' => 'LA CRUZ',
        'state_id' => 8
      ],
      [
        'name' => 'CUAUHTÉMOC',
        'state_id' => 8
      ],
      [
        'name' => 'CUSIHUIRIACHI',
        'state_id' => 8
      ],
      [
        'name' => 'CHIHUAHUA',
        'state_id' => 8
      ],
      [
        'name' => 'CHÍNIPAS',
        'state_id' => 8
      ],
      [
        'name' => 'DELICIAS',
        'state_id' => 8
      ],
      [
        'name' => 'DR. BELISARIO DOMÍNGUEZ',
        'state_id' => 8
      ],
      [
        'name' => 'GALEANA',
        'state_id' => 8
      ],
      [
        'name' => 'SANTA ISABEL',
        'state_id' => 8
      ],
      [
        'name' => 'GÓMEZ FARÍAS',
        'state_id' => 8
      ],
      [
        'name' => 'GRAN MORELOS',
        'state_id' => 8
      ],
      [
        'name' => 'GUACHOCHI',
        'state_id' => 8
      ],
      [
        'name' => 'GUADALUPE',
        'state_id' => 8
      ],
      [
        'name' => 'GUADALUPE Y CALVO',
        'state_id' => 8
      ],
      [
        'name' => 'GUAZAPARES',
        'state_id' => 8
      ],
      [
        'name' => 'GUERRERO',
        'state_id' => 8
      ],
      [
        'name' => 'HIDALGO DEL PARRAL',
        'state_id' => 8
      ],
      [
        'name' => 'HUEJOTITÁN',
        'state_id' => 8
      ],
      [
        'name' => 'IGNACIO ZARAGOZA',
        'state_id' => 8
      ],
      [
        'name' => 'JANOS',
        'state_id' => 8
      ],
      [
        'name' => 'JIMÉNEZ',
        'state_id' => 8
      ],
      [
        'name' => 'JUÁREZ',
        'state_id' => 8
      ],
      [
        'name' => 'JULIMES',
        'state_id' => 8
      ],
      [
        'name' => 'LÓPEZ',
        'state_id' => 8
      ],
      [
        'name' => 'MADERA',
        'state_id' => 8
      ],
      [
        'name' => 'MAGUARICHI',
        'state_id' => 8
      ],
      [
        'name' => 'MANUEL BENAVIDES',
        'state_id' => 8
      ],
      [
        'name' => 'MATACHÍ',
        'state_id' => 8
      ],
      [
        'name' => 'MATAMOROS',
        'state_id' => 8
      ],
      [
        'name' => 'MEOQUI',
        'state_id' => 8
      ],
      [
        'name' => 'MORELOS',
        'state_id' => 8
      ],
      [
        'name' => 'MORIS',
        'state_id' => 8
      ],
      [
        'name' => 'NAMIQUIPA',
        'state_id' => 8
      ],
      [
        'name' => 'NONOAVA',
        'state_id' => 8
      ],
      [
        'name' => 'NUEVO CASAS GRANDES',
        'state_id' => 8
      ],
      [
        'name' => 'OCAMPO',
        'state_id' => 8
      ],
      [
        'name' => 'OJINAGA',
        'state_id' => 8
      ],
      [
        'name' => 'PRAXEDIS G. GUERRERO',
        'state_id' => 8
      ],
      [
        'name' => 'RIVA PALACIO',
        'state_id' => 8
      ],
      [
        'name' => 'ROSALES',
        'state_id' => 8
      ],
      [
        'name' => 'ROSARIO',
        'state_id' => 8
      ],
      [
        'name' => 'SAN FRANCISCO DE BORJA',
        'state_id' => 8
      ],
      [
        'name' => 'SAN FRANCISCO DE CONCHOS',
        'state_id' => 8
      ],
      [
        'name' => 'SAN FRANCISCO DEL ORO',
        'state_id' => 8
      ],
      [
        'name' => 'SANTA BÁRBARA',
        'state_id' => 8
      ],
      [
        'name' => 'SATEVÓ',
        'state_id' => 8
      ],
      [
        'name' => 'SAUCILLO',
        'state_id' => 8
      ],
      [
        'name' => 'TEMÓSACHIC',
        'state_id' => 8
      ],
      [
        'name' => 'EL TULE',
        'state_id' => 8
      ],
      [
        'name' => 'URIQUE',
        'state_id' => 8
      ],
      [
        'name' => 'URUACHI',
        'state_id' => 8
      ],
      [
        'name' => 'VALLE DE ZARAGOZA',
        'state_id' => 8
      ],
      [
        'name' => 'AZCAPOTZALCO',
        'state_id' => 9
      ],
      [
        'name' => 'COYOACÁN',
        'state_id' => 9
      ],
      [
        'name' => 'CUAJIMALPA DE MORELOS',
        'state_id' => 9
      ],
      [
        'name' => 'GUSTAVO A. MADERO',
        'state_id' => 9
      ],
      [
        'name' => 'IZTACALCO',
        'state_id' => 9
      ],
      [
        'name' => 'IZTAPALAPA',
        'state_id' => 9
      ],
      [
        'name' => 'LA MAGDALENA CONTRERAS',
        'state_id' => 9
      ],
      [
        'name' => 'MILPA ALTA',
        'state_id' => 9
      ],
      [
        'name' => 'ÁLVARO OBREGÓN',
        'state_id' => 9
      ],
      [
        'name' => 'TLÁHUAC',
        'state_id' => 9
      ],
      [
        'name' => 'TLALPAN',
        'state_id' => 9
      ],
      [
        'name' => 'XOCHIMILCO',
        'state_id' => 9
      ],
      [
        'name' => 'BENITO JUÁREZ',
        'state_id' => 9
      ],
      [
        'name' => 'CUAUHTÉMOC',
        'state_id' => 9
      ],
      [
        'name' => 'MIGUEL HIDALGO',
        'state_id' => 9
      ],
      [
        'name' => 'VENUSTIANO CARRANZA',
        'state_id' => 9
      ],
      [
        'name' => 'CANATLÁN',
        'state_id' => 10
      ],
      [
        'name' => 'CANELAS',
        'state_id' => 10
      ],
      [
        'name' => 'CONETO DE COMONFORT',
        'state_id' => 10
      ],
      [
        'name' => 'CUENCAMÉ',
        'state_id' => 10
      ],
      [
        'name' => 'DURANGO',
        'state_id' => 10
      ],
      [
        'name' => 'GENERAL SIMÓN BOLÍVAR',
        'state_id' => 10
      ],
      [
        'name' => 'GÓMEZ PALACIO',
        'state_id' => 10
      ],
      [
        'name' => 'GUADALUPE VICTORIA',
        'state_id' => 10
      ],
      [
        'name' => 'GUANACEVÍ',
        'state_id' => 10
      ],
      [
        'name' => 'HIDALGO',
        'state_id' => 10
      ],
      [
        'name' => 'INDÉ',
        'state_id' => 10
      ],
      [
        'name' => 'LERDO',
        'state_id' => 10
      ],
      [
        'name' => 'MAPIMÍ',
        'state_id' => 10
      ],
      [
        'name' => 'MEZQUITAL',
        'state_id' => 10
      ],
      [
        'name' => 'NAZAS',
        'state_id' => 10
      ],
      [
        'name' => 'NOMBRE DE DIOS',
        'state_id' => 10
      ],
      [
        'name' => 'OCAMPO',
        'state_id' => 10
      ],
      [
        'name' => 'EL ORO',
        'state_id' => 10
      ],
      [
        'name' => 'OTÁEZ',
        'state_id' => 10
      ],
      [
        'name' => 'PÁNUCO DE CORONADO',
        'state_id' => 10
      ],
      [
        'name' => 'PEÑÓN BLANCO',
        'state_id' => 10
      ],
      [
        'name' => 'POANAS',
        'state_id' => 10
      ],
      [
        'name' => 'PUEBLO NUEVO',
        'state_id' => 10
      ],
      [
        'name' => 'RODEO',
        'state_id' => 10
      ],
      [
        'name' => 'SAN BERNARDO',
        'state_id' => 10
      ],
      [
        'name' => 'SAN DIMAS',
        'state_id' => 10
      ],
      [
        'name' => 'SAN JUAN DE GUADALUPE',
        'state_id' => 10
      ],
      [
        'name' => 'SAN JUAN DEL RÍO',
        'state_id' => 10
      ],
      [
        'name' => 'SAN LUIS DEL CORDERO',
        'state_id' => 10
      ],
      [
        'name' => 'SAN PEDRO DEL GALLO',
        'state_id' => 10
      ],
      [
        'name' => 'SANTA CLARA',
        'state_id' => 10
      ],
      [
        'name' => 'SANTIAGO PAPASQUIARO',
        'state_id' => 10
      ],
      [
        'name' => 'SÚCHIL',
        'state_id' => 10
      ],
      [
        'name' => 'TAMAZULA',
        'state_id' => 10
      ],
      [
        'name' => 'TEPEHUANES',
        'state_id' => 10
      ],
      [
        'name' => 'TLAHUALILO',
        'state_id' => 10
      ],
      [
        'name' => 'TOPIA',
        'state_id' => 10
      ],
      [
        'name' => 'VICENTE GUERRERO',
        'state_id' => 10
      ],
      [
        'name' => 'NUEVO IDEAL',
        'state_id' => 10
      ],
      [
        'name' => 'ABASOLO',
        'state_id' => 11
      ],
      [
        'name' => 'ACÁMBARO',
        'state_id' => 11
      ],
      [
        'name' => 'SAN MIGUEL DE ALLENDE',
        'state_id' => 11
      ],
      [
        'name' => 'APASEO EL ALTO',
        'state_id' => 11
      ],
      [
        'name' => 'APASEO EL GRANDE',
        'state_id' => 11
      ],
      [
        'name' => 'ATARJEA',
        'state_id' => 11
      ],
      [
        'name' => 'CELAYA',
        'state_id' => 11
      ],
      [
        'name' => 'MANUEL DOBLADO',
        'state_id' => 11
      ],
      [
        'name' => 'COMONFORT',
        'state_id' => 11
      ],
      [
        'name' => 'CORONEO',
        'state_id' => 11
      ],
      [
        'name' => 'CORTAZAR',
        'state_id' => 11
      ],
      [
        'name' => 'CUERÁMARO',
        'state_id' => 11
      ],
      [
        'name' => 'DOCTOR MORA',
        'state_id' => 11
      ],
      [
        'name' => 'DOLORES HIDALGO CUNA DE LA INDEPENDENCIA NACIONAL',
        'state_id' => 11
      ],
      [
        'name' => 'GUANAJUATO',
        'state_id' => 11
      ],
      [
        'name' => 'HUANÍMARO',
        'state_id' => 11
      ],
      [
        'name' => 'IRAPUATO',
        'state_id' => 11
      ],
      [
        'name' => 'JARAL DEL PROGRESO',
        'state_id' => 11
      ],
      [
        'name' => 'JERÉCUARO',
        'state_id' => 11
      ],
      [
        'name' => 'LEÓN',
        'state_id' => 11
      ],
      [
        'name' => 'MOROLEÓN',
        'state_id' => 11
      ],
      [
        'name' => 'OCAMPO',
        'state_id' => 11
      ],
      [
        'name' => 'PÉNJAMO',
        'state_id' => 11
      ],
      [
        'name' => 'PUEBLO NUEVO',
        'state_id' => 11
      ],
      [
        'name' => 'PURÍSIMA DEL RINCÓN',
        'state_id' => 11
      ],
      [
        'name' => 'ROMITA',
        'state_id' => 11
      ],
      [
        'name' => 'SALAMANCA',
        'state_id' => 11
      ],
      [
        'name' => 'SALVATIERRA',
        'state_id' => 11
      ],
      [
        'name' => 'SAN DIEGO DE LA UNIÓN',
        'state_id' => 11
      ],
      [
        'name' => 'SAN FELIPE',
        'state_id' => 11
      ],
      [
        'name' => 'SAN FRANCISCO DEL RINCÓN',
        'state_id' => 11
      ],
      [
        'name' => 'SAN JOSÉ ITURBIDE',
        'state_id' => 11
      ],
      [
        'name' => 'SAN LUIS DE LA PAZ',
        'state_id' => 11
      ],
      [
        'name' => 'SANTA CATARINA',
        'state_id' => 11
      ],
      [
        'name' => 'SANTA CRUZ DE JUVENTINO ROSAS',
        'state_id' => 11
      ],
      [
        'name' => 'SANTIAGO MARAVATÍO',
        'state_id' => 11
      ],
      [
        'name' => 'SILAO DE LA VICTORIA',
        'state_id' => 11
      ],
      [
        'name' => 'TARANDACUAO',
        'state_id' => 11
      ],
      [
        'name' => 'TARIMORO',
        'state_id' => 11
      ],
      [
        'name' => 'TIERRA BLANCA',
        'state_id' => 11
      ],
      [
        'name' => 'URIANGATO',
        'state_id' => 11
      ],
      [
        'name' => 'VALLE DE SANTIAGO',
        'state_id' => 11
      ],
      [
        'name' => 'VICTORIA',
        'state_id' => 11
      ],
      [
        'name' => 'VILLAGRÁN',
        'state_id' => 11
      ],
      [
        'name' => 'XICHÚ',
        'state_id' => 11
      ],
      [
        'name' => 'YURIRIA',
        'state_id' => 11
      ],
      [
        'name' => 'ACAPULCO DE JUÁREZ',
        'state_id' => 12
      ],
      [
        'name' => 'AHUACUOTZINGO',
        'state_id' => 12
      ],
      [
        'name' => 'AJUCHITLÁN DEL PROGRESO',
        'state_id' => 12
      ],
      [
        'name' => 'ALCOZAUCA DE GUERRERO',
        'state_id' => 12
      ],
      [
        'name' => 'ALPOYECA',
        'state_id' => 12
      ],
      [
        'name' => 'APAXTLA',
        'state_id' => 12
      ],
      [
        'name' => 'ARCELIA',
        'state_id' => 12
      ],
      [
        'name' => 'ATENANGO DEL RÍO',
        'state_id' => 12
      ],
      [
        'name' => 'ATLAMAJALCINGO DEL MONTE',
        'state_id' => 12
      ],
      [
        'name' => 'ATLIXTAC',
        'state_id' => 12
      ],
      [
        'name' => 'ATOYAC DE ÁLVAREZ',
        'state_id' => 12
      ],
      [
        'name' => 'AYUTLA DE LOS LIBRES',
        'state_id' => 12
      ],
      [
        'name' => 'AZOYÚ',
        'state_id' => 12
      ],
      [
        'name' => 'BENITO JUÁREZ',
        'state_id' => 12
      ],
      [
        'name' => 'BUENAVISTA DE CUÉLLAR',
        'state_id' => 12
      ],
      [
        'name' => 'COAHUAYUTLA DE JOSÉ MARÍA IZAZAGA',
        'state_id' => 12
      ],
      [
        'name' => 'COCULA',
        'state_id' => 12
      ],
      [
        'name' => 'COPALA',
        'state_id' => 12
      ],
      [
        'name' => 'COPALILLO',
        'state_id' => 12
      ],
      [
        'name' => 'COPANATOYAC',
        'state_id' => 12
      ],
      [
        'name' => 'COYUCA DE BENÍTEZ',
        'state_id' => 12
      ],
      [
        'name' => 'COYUCA DE CATALÁN',
        'state_id' => 12
      ],
      [
        'name' => 'CUAJINICUILAPA',
        'state_id' => 12
      ],
      [
        'name' => 'CUALÁC',
        'state_id' => 12
      ],
      [
        'name' => 'CUAUTEPEC',
        'state_id' => 12
      ],
      [
        'name' => 'CUETZALA DEL PROGRESO',
        'state_id' => 12
      ],
      [
        'name' => 'CUTZAMALA DE PINZÓN',
        'state_id' => 12
      ],
      [
        'name' => 'CHILAPA DE ÁLVAREZ',
        'state_id' => 12
      ],
      [
        'name' => 'CHILPANCINGO DE LOS BRAVO',
        'state_id' => 12
      ],
      [
        'name' => 'FLORENCIO VILLARREAL',
        'state_id' => 12
      ],
      [
        'name' => 'GENERAL CANUTO A. NERI',
        'state_id' => 12
      ],
      [
        'name' => 'GENERAL HELIODORO CASTILLO',
        'state_id' => 12
      ],
      [
        'name' => 'HUAMUXTITLÁN',
        'state_id' => 12
      ],
      [
        'name' => 'HUITZUCO DE LOS FIGUEROA',
        'state_id' => 12
      ],
      [
        'name' => 'IGUALA DE LA INDEPENDENCIA',
        'state_id' => 12
      ],
      [
        'name' => 'IGUALAPA',
        'state_id' => 12
      ],
      [
        'name' => 'IXCATEOPAN DE CUAUHTÉMOC',
        'state_id' => 12
      ],
      [
        'name' => 'ZIHUATANEJO DE AZUETA',
        'state_id' => 12
      ],
      [
        'name' => 'JUAN R. ESCUDERO',
        'state_id' => 12
      ],
      [
        'name' => 'LEONARDO BRAVO',
        'state_id' => 12
      ],
      [
        'name' => 'MALINALTEPEC',
        'state_id' => 12
      ],
      [
        'name' => 'MÁRTIR DE CUILAPAN',
        'state_id' => 12
      ],
      [
        'name' => 'METLATÓNOC',
        'state_id' => 12
      ],
      [
        'name' => 'MOCHITLÁN',
        'state_id' => 12
      ],
      [
        'name' => 'OLINALÁ',
        'state_id' => 12
      ],
      [
        'name' => 'OMETEPEC',
        'state_id' => 12
      ],
      [
        'name' => 'PEDRO ASCENCIO ALQUISIRAS',
        'state_id' => 12
      ],
      [
        'name' => 'PETATLÁN',
        'state_id' => 12
      ],
      [
        'name' => 'PILCAYA',
        'state_id' => 12
      ],
      [
        'name' => 'PUNGARABATO',
        'state_id' => 12
      ],
      [
        'name' => 'QUECHULTENANGO',
        'state_id' => 12
      ],
      [
        'name' => 'SAN LUIS ACATLÁN',
        'state_id' => 12
      ],
      [
        'name' => 'SAN MARCOS',
        'state_id' => 12
      ],
      [
        'name' => 'SAN MIGUEL TOTOLAPAN',
        'state_id' => 12
      ],
      [
        'name' => 'TAXCO DE ALARCÓN',
        'state_id' => 12
      ],
      [
        'name' => 'TECOANAPA',
        'state_id' => 12
      ],
      [
        'name' => 'TÉCPAN DE GALEANA',
        'state_id' => 12
      ],
      [
        'name' => 'TELOLOAPAN',
        'state_id' => 12
      ],
      [
        'name' => 'TEPECOACUILCO DE TRUJANO',
        'state_id' => 12
      ],
      [
        'name' => 'TETIPAC',
        'state_id' => 12
      ],
      [
        'name' => 'TIXTLA DE GUERRERO',
        'state_id' => 12
      ],
      [
        'name' => 'TLACOACHISTLAHUACA',
        'state_id' => 12
      ],
      [
        'name' => 'TLACOAPA',
        'state_id' => 12
      ],
      [
        'name' => 'TLALCHAPA',
        'state_id' => 12
      ],
      [
        'name' => 'TLALIXTAQUILLA DE MALDONADO',
        'state_id' => 12
      ],
      [
        'name' => 'TLAPA DE COMONFORT',
        'state_id' => 12
      ],
      [
        'name' => 'TLAPEHUALA',
        'state_id' => 12
      ],
      [
        'name' => 'LA UNIÓN DE ISIDORO MONTES DE OCA',
        'state_id' => 12
      ],
      [
        'name' => 'XALPATLÁHUAC',
        'state_id' => 12
      ],
      [
        'name' => 'XOCHIHUEHUETLÁN',
        'state_id' => 12
      ],
      [
        'name' => 'XOCHISTLAHUACA',
        'state_id' => 12
      ],
      [
        'name' => 'ZAPOTITLÁN TABLAS',
        'state_id' => 12
      ],
      [
        'name' => 'ZIRÁNDARO',
        'state_id' => 12
      ],
      [
        'name' => 'ZITLALA',
        'state_id' => 12
      ],
      [
        'name' => 'EDUARDO NERI',
        'state_id' => 12
      ],
      [
        'name' => 'ACATEPEC',
        'state_id' => 12
      ],
      [
        'name' => 'MARQUELIA',
        'state_id' => 12
      ],
      [
        'name' => 'COCHOAPA EL GRANDE',
        'state_id' => 12
      ],
      [
        'name' => 'JOSÉ JOAQUÍN DE HERRERA',
        'state_id' => 12
      ],
      [
        'name' => 'JUCHITÁN',
        'state_id' => 12
      ],
      [
        'name' => 'ILIATENCO',
        'state_id' => 12
      ],
      [
        'name' => 'ACATLÁN',
        'state_id' => 13
      ],
      [
        'name' => 'ACAXOCHITLÁN',
        'state_id' => 13
      ],
      [
        'name' => 'ACTOPAN',
        'state_id' => 13
      ],
      [
        'name' => 'AGUA BLANCA DE ITURBIDE',
        'state_id' => 13
      ],
      [
        'name' => 'AJACUBA',
        'state_id' => 13
      ],
      [
        'name' => 'ALFAJAYUCAN',
        'state_id' => 13
      ],
      [
        'name' => 'ALMOLOYA',
        'state_id' => 13
      ],
      [
        'name' => 'APAN',
        'state_id' => 13
      ],
      [
        'name' => 'EL ARENAL',
        'state_id' => 13
      ],
      [
        'name' => 'ATITALAQUIA',
        'state_id' => 13
      ],
      [
        'name' => 'ATLAPEXCO',
        'state_id' => 13
      ],
      [
        'name' => 'ATOTONILCO EL GRANDE',
        'state_id' => 13
      ],
      [
        'name' => 'ATOTONILCO DE TULA',
        'state_id' => 13
      ],
      [
        'name' => 'CALNALI',
        'state_id' => 13
      ],
      [
        'name' => 'CARDONAL',
        'state_id' => 13
      ],
      [
        'name' => 'CUAUTEPEC DE HINOJOSA',
        'state_id' => 13
      ],
      [
        'name' => 'CHAPANTONGO',
        'state_id' => 13
      ],
      [
        'name' => 'CHAPULHUACÁN',
        'state_id' => 13
      ],
      [
        'name' => 'CHILCUAUTLA',
        'state_id' => 13
      ],
      [
        'name' => 'ELOXOCHITLÁN',
        'state_id' => 13
      ],
      [
        'name' => 'EMILIANO ZAPATA',
        'state_id' => 13
      ],
      [
        'name' => 'EPAZOYUCAN',
        'state_id' => 13
      ],
      [
        'name' => 'FRANCISCO I. MADERO',
        'state_id' => 13
      ],
      [
        'name' => 'HUASCA DE OCAMPO',
        'state_id' => 13
      ],
      [
        'name' => 'HUAUTLA',
        'state_id' => 13
      ],
      [
        'name' => 'HUAZALINGO',
        'state_id' => 13
      ],
      [
        'name' => 'HUEHUETLA',
        'state_id' => 13
      ],
      [
        'name' => 'HUEJUTLA DE REYES',
        'state_id' => 13
      ],
      [
        'name' => 'HUICHAPAN',
        'state_id' => 13
      ],
      [
        'name' => 'IXMIQUILPAN',
        'state_id' => 13
      ],
      [
        'name' => 'JACALA DE LEDEZMA',
        'state_id' => 13
      ],
      [
        'name' => 'JALTOCÁN',
        'state_id' => 13
      ],
      [
        'name' => 'JUÁREZ HIDALGO',
        'state_id' => 13
      ],
      [
        'name' => 'LOLOTLA',
        'state_id' => 13
      ],
      [
        'name' => 'METEPEC',
        'state_id' => 13
      ],
      [
        'name' => 'SAN AGUSTÍN METZQUITITLÁN',
        'state_id' => 13
      ],
      [
        'name' => 'METZTITLÁN',
        'state_id' => 13
      ],
      [
        'name' => 'MINERAL DEL CHICO',
        'state_id' => 13
      ],
      [
        'name' => 'MINERAL DEL MONTE',
        'state_id' => 13
      ],
      [
        'name' => 'LA MISIÓN',
        'state_id' => 13
      ],
      [
        'name' => 'MIXQUIAHUALA DE JUÁREZ',
        'state_id' => 13
      ],
      [
        'name' => 'MOLANGO DE ESCAMILLA',
        'state_id' => 13
      ],
      [
        'name' => 'NICOLÁS FLORES',
        'state_id' => 13
      ],
      [
        'name' => 'NOPALA DE VILLAGRÁN',
        'state_id' => 13
      ],
      [
        'name' => 'OMITLÁN DE JUÁREZ',
        'state_id' => 13
      ],
      [
        'name' => 'SAN FELIPE ORIZATLÁN',
        'state_id' => 13
      ],
      [
        'name' => 'PACULA',
        'state_id' => 13
      ],
      [
        'name' => 'PACHUCA DE SOTO',
        'state_id' => 13
      ],
      [
        'name' => 'PISAFLORES',
        'state_id' => 13
      ],
      [
        'name' => 'PROGRESO DE OBREGÓN',
        'state_id' => 13
      ],
      [
        'name' => 'MINERAL DE LA REFORMA',
        'state_id' => 13
      ],
      [
        'name' => 'SAN AGUSTÍN TLAXIACA',
        'state_id' => 13
      ],
      [
        'name' => 'SAN BARTOLO TUTOTEPEC',
        'state_id' => 13
      ],
      [
        'name' => 'SAN SALVADOR',
        'state_id' => 13
      ],
      [
        'name' => 'SANTIAGO DE ANAYA',
        'state_id' => 13
      ],
      [
        'name' => 'SANTIAGO TULANTEPEC DE LUGO GUERRERO',
        'state_id' => 13
      ],
      [
        'name' => 'SINGUILUCAN',
        'state_id' => 13
      ],
      [
        'name' => 'TASQUILLO',
        'state_id' => 13
      ],
      [
        'name' => 'TECOZAUTLA',
        'state_id' => 13
      ],
      [
        'name' => 'TENANGO DE DORIA',
        'state_id' => 13
      ],
      [
        'name' => 'TEPEAPULCO',
        'state_id' => 13
      ],
      [
        'name' => 'TEPEHUACÁN DE GUERRERO',
        'state_id' => 13
      ],
      [
        'name' => 'TEPEJI DEL RÍO DE OCAMPO',
        'state_id' => 13
      ],
      [
        'name' => 'TEPETITLÁN',
        'state_id' => 13
      ],
      [
        'name' => 'TETEPANGO',
        'state_id' => 13
      ],
      [
        'name' => 'VILLA DE TEZONTEPEC',
        'state_id' => 13
      ],
      [
        'name' => 'TEZONTEPEC DE ALDAMA',
        'state_id' => 13
      ],
      [
        'name' => 'TIANGUISTENGO',
        'state_id' => 13
      ],
      [
        'name' => 'TIZAYUCA',
        'state_id' => 13
      ],
      [
        'name' => 'TLAHUELILPAN',
        'state_id' => 13
      ],
      [
        'name' => 'TLAHUILTEPA',
        'state_id' => 13
      ],
      [
        'name' => 'TLANALAPA',
        'state_id' => 13
      ],
      [
        'name' => 'TLANCHINOL',
        'state_id' => 13
      ],
      [
        'name' => 'TLAXCOAPAN',
        'state_id' => 13
      ],
      [
        'name' => 'TOLCAYUCA',
        'state_id' => 13
      ],
      [
        'name' => 'TULA DE ALLENDE',
        'state_id' => 13
      ],
      [
        'name' => 'TULANCINGO DE BRAVO',
        'state_id' => 13
      ],
      [
        'name' => 'XOCHIATIPAN',
        'state_id' => 13
      ],
      [
        'name' => 'XOCHICOATLÁN',
        'state_id' => 13
      ],
      [
        'name' => 'YAHUALICA',
        'state_id' => 13
      ],
      [
        'name' => 'ZACUALTIPÁN DE ÁNGELES',
        'state_id' => 13
      ],
      [
        'name' => 'ZAPOTLÁN DE JUÁREZ',
        'state_id' => 13
      ],
      [
        'name' => 'ZEMPOALA',
        'state_id' => 13
      ],
      [
        'name' => 'ZIMAPÁN',
        'state_id' => 13
      ],
      [
        'name' => 'ACATIC',
        'state_id' => 14
      ],
      [
        'name' => 'ACATLÁN DE JUÁREZ',
        'state_id' => 14
      ],
      [
        'name' => 'AHUALULCO DE MERCADO',
        'state_id' => 14
      ],
      [
        'name' => 'AMACUECA',
        'state_id' => 14
      ],
      [
        'name' => 'AMATITÁN',
        'state_id' => 14
      ],
      [
        'name' => 'AMECA',
        'state_id' => 14
      ],
      [
        'name' => 'SAN JUANITO DE ESCOBEDO',
        'state_id' => 14
      ],
      [
        'name' => 'ARANDAS',
        'state_id' => 14
      ],
      [
        'name' => 'EL ARENAL',
        'state_id' => 14
      ],
      [
        'name' => 'ATEMAJAC DE BRIZUELA',
        'state_id' => 14
      ],
      [
        'name' => 'ATENGO',
        'state_id' => 14
      ],
      [
        'name' => 'ATENGUILLO',
        'state_id' => 14
      ],
      [
        'name' => 'ATOTONILCO EL ALTO',
        'state_id' => 14
      ],
      [
        'name' => 'ATOYAC',
        'state_id' => 14
      ],
      [
        'name' => 'AUTLÁN DE NAVARRO',
        'state_id' => 14
      ],
      [
        'name' => 'AYOTLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'AYUTLA',
        'state_id' => 14
      ],
      [
        'name' => 'LA BARCA',
        'state_id' => 14
      ],
      [
        'name' => 'BOLAÑOS',
        'state_id' => 14
      ],
      [
        'name' => 'CABO CORRIENTES',
        'state_id' => 14
      ],
      [
        'name' => 'CASIMIRO CASTILLO',
        'state_id' => 14
      ],
      [
        'name' => 'CIHUATLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'ZAPOTLÁN EL GRANDE',
        'state_id' => 14
      ],
      [
        'name' => 'COCULA',
        'state_id' => 14
      ],
      [
        'name' => 'COLOTLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'CONCEPCIÓN DE BUENOS AIRES',
        'state_id' => 14
      ],
      [
        'name' => 'CUAUTITLÁN DE GARCÍA BARRAGÁN',
        'state_id' => 14
      ],
      [
        'name' => 'CUAUTLA',
        'state_id' => 14
      ],
      [
        'name' => 'CUQUÍO',
        'state_id' => 14
      ],
      [
        'name' => 'CHAPALA',
        'state_id' => 14
      ],
      [
        'name' => 'CHIMALTITÁN',
        'state_id' => 14
      ],
      [
        'name' => 'CHIQUILISTLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'DEGOLLADO',
        'state_id' => 14
      ],
      [
        'name' => 'EJUTLA',
        'state_id' => 14
      ],
      [
        'name' => 'ENCARNACIÓN DE DÍAZ',
        'state_id' => 14
      ],
      [
        'name' => 'ETZATLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'EL GRULLO',
        'state_id' => 14
      ],
      [
        'name' => 'GUACHINANGO',
        'state_id' => 14
      ],
      [
        'name' => 'GUADALAJARA',
        'state_id' => 14
      ],
      [
        'name' => 'HOSTOTIPAQUILLO',
        'state_id' => 14
      ],
      [
        'name' => 'HUEJÚCAR',
        'state_id' => 14
      ],
      [
        'name' => 'HUEJUQUILLA EL ALTO',
        'state_id' => 14
      ],
      [
        'name' => 'LA HUERTA',
        'state_id' => 14
      ],
      [
        'name' => 'IXTLAHUACÁN DE LOS MEMBRILLOS',
        'state_id' => 14
      ],
      [
        'name' => 'IXTLAHUACÁN DEL RÍO',
        'state_id' => 14
      ],
      [
        'name' => 'JALOSTOTITLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'JAMAY',
        'state_id' => 14
      ],
      [
        'name' => 'JESÚS MARÍA',
        'state_id' => 14
      ],
      [
        'name' => 'JILOTLÁN DE LOS DOLORES',
        'state_id' => 14
      ],
      [
        'name' => 'JOCOTEPEC',
        'state_id' => 14
      ],
      [
        'name' => 'JUANACATLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'JUCHITLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'LAGOS DE MORENO',
        'state_id' => 14
      ],
      [
        'name' => 'EL LIMÓN',
        'state_id' => 14
      ],
      [
        'name' => 'MAGDALENA',
        'state_id' => 14
      ],
      [
        'name' => 'SANTA MARÍA DEL ORO',
        'state_id' => 14
      ],
      [
        'name' => 'LA MANZANILLA DE LA PAZ',
        'state_id' => 14
      ],
      [
        'name' => 'MASCOTA',
        'state_id' => 14
      ],
      [
        'name' => 'MAZAMITLA',
        'state_id' => 14
      ],
      [
        'name' => 'MEXTICACÁN',
        'state_id' => 14
      ],
      [
        'name' => 'MEZQUITIC',
        'state_id' => 14
      ],
      [
        'name' => 'MIXTLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'OCOTLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'OJUELOS DE JALISCO',
        'state_id' => 14
      ],
      [
        'name' => 'PIHUAMO',
        'state_id' => 14
      ],
      [
        'name' => 'PONCITLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'PUERTO VALLARTA',
        'state_id' => 14
      ],
      [
        'name' => 'VILLA PURIFICACIÓN',
        'state_id' => 14
      ],
      [
        'name' => 'QUITUPAN',
        'state_id' => 14
      ],
      [
        'name' => 'EL SALTO',
        'state_id' => 14
      ],
      [
        'name' => 'SAN CRISTÓBAL DE LA BARRANCA',
        'state_id' => 14
      ],
      [
        'name' => 'SAN DIEGO DE ALEJANDRÍA',
        'state_id' => 14
      ],
      [
        'name' => 'SAN JUAN DE LOS LAGOS',
        'state_id' => 14
      ],
      [
        'name' => 'SAN JULIÁN',
        'state_id' => 14
      ],
      [
        'name' => 'SAN MARCOS',
        'state_id' => 14
      ],
      [
        'name' => 'SAN MARTÍN DE BOLAÑOS',
        'state_id' => 14
      ],
      [
        'name' => 'SAN MARTÍN HIDALGO',
        'state_id' => 14
      ],
      [
        'name' => 'SAN MIGUEL EL ALTO',
        'state_id' => 14
      ],
      [
        'name' => 'GÓMEZ FARÍAS',
        'state_id' => 14
      ],
      [
        'name' => 'SAN SEBASTIÁN DEL OESTE',
        'state_id' => 14
      ],
      [
        'name' => 'SANTA MARÍA DE LOS ÁNGELES',
        'state_id' => 14
      ],
      [
        'name' => 'SAYULA',
        'state_id' => 14
      ],
      [
        'name' => 'TALA',
        'state_id' => 14
      ],
      [
        'name' => 'TALPA DE ALLENDE',
        'state_id' => 14
      ],
      [
        'name' => 'TAMAZULA DE GORDIANO',
        'state_id' => 14
      ],
      [
        'name' => 'TAPALPA',
        'state_id' => 14
      ],
      [
        'name' => 'TECALITLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'TECOLOTLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'TECHALUTA DE MONTENEGRO',
        'state_id' => 14
      ],
      [
        'name' => 'TENAMAXTLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'TEOCALTICHE',
        'state_id' => 14
      ],
      [
        'name' => 'TEOCUITATLÁN DE CORONA',
        'state_id' => 14
      ],
      [
        'name' => 'TEPATITLÁN DE MORELOS',
        'state_id' => 14
      ],
      [
        'name' => 'TEQUILA',
        'state_id' => 14
      ],
      [
        'name' => 'TEUCHITLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'TIZAPÁN EL ALTO',
        'state_id' => 14
      ],
      [
        'name' => 'TLAJOMULCO DE ZÚÑIGA',
        'state_id' => 14
      ],
      [
        'name' => 'SAN PEDRO TLAQUEPAQUE',
        'state_id' => 14
      ],
      [
        'name' => 'TOLIMÁN',
        'state_id' => 14
      ],
      [
        'name' => 'TOMATLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'TONALÁ',
        'state_id' => 14
      ],
      [
        'name' => 'TONAYA',
        'state_id' => 14
      ],
      [
        'name' => 'TONILA',
        'state_id' => 14
      ],
      [
        'name' => 'TOTATICHE',
        'state_id' => 14
      ],
      [
        'name' => 'TOTOTLÁN',
        'state_id' => 14
      ],
      [
        'name' => 'TUXCACUESCO',
        'state_id' => 14
      ],
      [
        'name' => 'TUXCUECA',
        'state_id' => 14
      ],
      [
        'name' => 'TUXPAN',
        'state_id' => 14
      ],
      [
        'name' => 'UNIÓN DE SAN ANTONIO',
        'state_id' => 14
      ],
      [
        'name' => 'UNIÓN DE TULA',
        'state_id' => 14
      ],
      [
        'name' => 'VALLE DE GUADALUPE',
        'state_id' => 14
      ],
      [
        'name' => 'VALLE DE JUÁREZ',
        'state_id' => 14
      ],
      [
        'name' => 'SAN GABRIEL',
        'state_id' => 14
      ],
      [
        'name' => 'VILLA CORONA',
        'state_id' => 14
      ],
      [
        'name' => 'VILLA GUERRERO',
        'state_id' => 14
      ],
      [
        'name' => 'VILLA HIDALGO',
        'state_id' => 14
      ],
      [
        'name' => 'CAÑADAS DE OBREGÓN',
        'state_id' => 14
      ],
      [
        'name' => 'YAHUALICA DE GONZÁLEZ GALLO',
        'state_id' => 14
      ],
      [
        'name' => 'ZACOALCO DE TORRES',
        'state_id' => 14
      ],
      [
        'name' => 'ZAPOPAN',
        'state_id' => 14
      ],
      [
        'name' => 'ZAPOTILTIC',
        'state_id' => 14
      ],
      [
        'name' => 'ZAPOTITLÁN DE VADILLO',
        'state_id' => 14
      ],
      [
        'name' => 'ZAPOTLÁN DEL REY',
        'state_id' => 14
      ],
      [
        'name' => 'ZAPOTLANEJO',
        'state_id' => 14
      ],
      [
        'name' => 'SAN IGNACIO CERRO GORDO',
        'state_id' => 14
      ],
      [
        'name' => 'ACAMBAY DE RUÍZ CASTAÑEDA',
        'state_id' => 15
      ],
      [
        'name' => 'ACOLMAN',
        'state_id' => 15
      ],
      [
        'name' => 'ACULCO',
        'state_id' => 15
      ],
      [
        'name' => 'ALMOLOYA DE ALQUISIRAS',
        'state_id' => 15
      ],
      [
        'name' => 'ALMOLOYA DE JUÁREZ',
        'state_id' => 15
      ],
      [
        'name' => 'ALMOLOYA DEL RÍO',
        'state_id' => 15
      ],
      [
        'name' => 'AMANALCO',
        'state_id' => 15
      ],
      [
        'name' => 'AMATEPEC',
        'state_id' => 15
      ],
      [
        'name' => 'AMECAMECA',
        'state_id' => 15
      ],
      [
        'name' => 'APAXCO',
        'state_id' => 15
      ],
      [
        'name' => 'ATENCO',
        'state_id' => 15
      ],
      [
        'name' => 'ATIZAPÁN',
        'state_id' => 15
      ],
      [
        'name' => 'ATIZAPÁN DE ZARAGOZA',
        'state_id' => 15
      ],
      [
        'name' => 'ATLACOMULCO',
        'state_id' => 15
      ],
      [
        'name' => 'ATLAUTLA',
        'state_id' => 15
      ],
      [
        'name' => 'AXAPUSCO',
        'state_id' => 15
      ],
      [
        'name' => 'AYAPANGO',
        'state_id' => 15
      ],
      [
        'name' => 'CALIMAYA',
        'state_id' => 15
      ],
      [
        'name' => 'CAPULHUAC',
        'state_id' => 15
      ],
      [
        'name' => 'COACALCO DE BERRIOZÁBAL',
        'state_id' => 15
      ],
      [
        'name' => 'COATEPEC HARINAS',
        'state_id' => 15
      ],
      [
        'name' => 'COCOTITLÁN',
        'state_id' => 15
      ],
      [
        'name' => 'COYOTEPEC',
        'state_id' => 15
      ],
      [
        'name' => 'CUAUTITLÁN',
        'state_id' => 15
      ],
      [
        'name' => 'CHALCO',
        'state_id' => 15
      ],
      [
        'name' => 'CHAPA DE MOTA',
        'state_id' => 15
      ],
      [
        'name' => 'CHAPULTEPEC',
        'state_id' => 15
      ],
      [
        'name' => 'CHIAUTLA',
        'state_id' => 15
      ],
      [
        'name' => 'CHICOLOAPAN',
        'state_id' => 15
      ],
      [
        'name' => 'CHICONCUAC',
        'state_id' => 15
      ],
      [
        'name' => 'CHIMALHUACÁN',
        'state_id' => 15
      ],
      [
        'name' => 'DONATO GUERRA',
        'state_id' => 15
      ],
      [
        'name' => 'ECATEPEC DE MORELOS',
        'state_id' => 15
      ],
      [
        'name' => 'ECATZINGO',
        'state_id' => 15
      ],
      [
        'name' => 'HUEHUETOCA',
        'state_id' => 15
      ],
      [
        'name' => 'HUEYPOXTLA',
        'state_id' => 15
      ],
      [
        'name' => 'HUIXQUILUCAN',
        'state_id' => 15
      ],
      [
        'name' => 'ISIDRO FABELA',
        'state_id' => 15
      ],
      [
        'name' => 'IXTAPALUCA',
        'state_id' => 15
      ],
      [
        'name' => 'IXTAPAN DE LA SAL',
        'state_id' => 15
      ],
      [
        'name' => 'IXTAPAN DEL ORO',
        'state_id' => 15
      ],
      [
        'name' => 'IXTLAHUACA',
        'state_id' => 15
      ],
      [
        'name' => 'XALATLACO',
        'state_id' => 15
      ],
      [
        'name' => 'JALTENCO',
        'state_id' => 15
      ],
      [
        'name' => 'JILOTEPEC',
        'state_id' => 15
      ],
      [
        'name' => 'JILOTZINGO',
        'state_id' => 15
      ],
      [
        'name' => 'JIQUIPILCO',
        'state_id' => 15
      ],
      [
        'name' => 'JOCOTITLÁN',
        'state_id' => 15
      ],
      [
        'name' => 'JOQUICINGO',
        'state_id' => 15
      ],
      [
        'name' => 'JUCHITEPEC',
        'state_id' => 15
      ],
      [
        'name' => 'LERMA',
        'state_id' => 15
      ],
      [
        'name' => 'MALINALCO',
        'state_id' => 15
      ],
      [
        'name' => 'MELCHOR OCAMPO',
        'state_id' => 15
      ],
      [
        'name' => 'METEPEC',
        'state_id' => 15
      ],
      [
        'name' => 'MEXICALTZINGO',
        'state_id' => 15
      ],
      [
        'name' => 'MORELOS',
        'state_id' => 15
      ],
      [
        'name' => 'NAUCALPAN DE JUÁREZ',
        'state_id' => 15
      ],
      [
        'name' => 'NEZAHUALCÓYOTL',
        'state_id' => 15
      ],
      [
        'name' => 'NEXTLALPAN',
        'state_id' => 15
      ],
      [
        'name' => 'NICOLÁS ROMERO',
        'state_id' => 15
      ],
      [
        'name' => 'NOPALTEPEC',
        'state_id' => 15
      ],
      [
        'name' => 'OCOYOACAC',
        'state_id' => 15
      ],
      [
        'name' => 'OCUILAN',
        'state_id' => 15
      ],
      [
        'name' => 'EL ORO',
        'state_id' => 15
      ],
      [
        'name' => 'OTUMBA',
        'state_id' => 15
      ],
      [
        'name' => 'OTZOLOAPAN',
        'state_id' => 15
      ],
      [
        'name' => 'OTZOLOTEPEC',
        'state_id' => 15
      ],
      [
        'name' => 'OZUMBA',
        'state_id' => 15
      ],
      [
        'name' => 'PAPALOTLA',
        'state_id' => 15
      ],
      [
        'name' => 'LA PAZ',
        'state_id' => 15
      ],
      [
        'name' => 'POLOTITLÁN',
        'state_id' => 15
      ],
      [
        'name' => 'RAYÓN',
        'state_id' => 15
      ],
      [
        'name' => 'SAN ANTONIO LA ISLA',
        'state_id' => 15
      ],
      [
        'name' => 'SAN FELIPE DEL PROGRESO',
        'state_id' => 15
      ],
      [
        'name' => 'SAN MARTÍN DE LAS PIRÁMIDES',
        'state_id' => 15
      ],
      [
        'name' => 'SAN MATEO ATENCO',
        'state_id' => 15
      ],
      [
        'name' => 'SAN SIMÓN DE GUERRERO',
        'state_id' => 15
      ],
      [
        'name' => 'SANTO TOMÁS',
        'state_id' => 15
      ],
      [
        'name' => 'SOYANIQUILPAN DE JUÁREZ',
        'state_id' => 15
      ],
      [
        'name' => 'SULTEPEC',
        'state_id' => 15
      ],
      [
        'name' => 'TECÁMAC',
        'state_id' => 15
      ],
      [
        'name' => 'TEJUPILCO',
        'state_id' => 15
      ],
      [
        'name' => 'TEMAMATLA',
        'state_id' => 15
      ],
      [
        'name' => 'TEMASCALAPA',
        'state_id' => 15
      ],
      [
        'name' => 'TEMASCALCINGO',
        'state_id' => 15
      ],
      [
        'name' => 'TEMASCALTEPEC',
        'state_id' => 15
      ],
      [
        'name' => 'TEMOAYA',
        'state_id' => 15
      ],
      [
        'name' => 'TENANCINGO',
        'state_id' => 15
      ],
      [
        'name' => 'TENANGO DEL AIRE',
        'state_id' => 15
      ],
      [
        'name' => 'TENANGO DEL VALLE',
        'state_id' => 15
      ],
      [
        'name' => 'TEOLOYUCAN',
        'state_id' => 15
      ],
      [
        'name' => 'TEOTIHUACÁN',
        'state_id' => 15
      ],
      [
        'name' => 'TEPETLAOXTOC',
        'state_id' => 15
      ],
      [
        'name' => 'TEPETLIXPA',
        'state_id' => 15
      ],
      [
        'name' => 'TEPOTZOTLÁN',
        'state_id' => 15
      ],
      [
        'name' => 'TEQUIXQUIAC',
        'state_id' => 15
      ],
      [
        'name' => 'TEXCALTITLÁN',
        'state_id' => 15
      ],
      [
        'name' => 'TEXCALYACAC',
        'state_id' => 15
      ],
      [
        'name' => 'TEXCOCO',
        'state_id' => 15
      ],
      [
        'name' => 'TEZOYUCA',
        'state_id' => 15
      ],
      [
        'name' => 'TIANGUISTENCO',
        'state_id' => 15
      ],
      [
        'name' => 'TIMILPAN',
        'state_id' => 15
      ],
      [
        'name' => 'TLALMANALCO',
        'state_id' => 15
      ],
      [
        'name' => 'TLALNEPANTLA DE BAZ',
        'state_id' => 15
      ],
      [
        'name' => 'TLATLAYA',
        'state_id' => 15
      ],
      [
        'name' => 'TOLUCA',
        'state_id' => 15
      ],
      [
        'name' => 'TONATICO',
        'state_id' => 15
      ],
      [
        'name' => 'TULTEPEC',
        'state_id' => 15
      ],
      [
        'name' => 'TULTITLÁN',
        'state_id' => 15
      ],
      [
        'name' => 'VALLE DE BRAVO',
        'state_id' => 15
      ],
      [
        'name' => 'VILLA DE ALLENDE',
        'state_id' => 15
      ],
      [
        'name' => 'VILLA DEL CARBÓN',
        'state_id' => 15
      ],
      [
        'name' => 'VILLA GUERRERO',
        'state_id' => 15
      ],
      [
        'name' => 'VILLA VICTORIA',
        'state_id' => 15
      ],
      [
        'name' => 'XONACATLÁN',
        'state_id' => 15
      ],
      [
        'name' => 'ZACAZONAPAN',
        'state_id' => 15
      ],
      [
        'name' => 'ZACUALPAN',
        'state_id' => 15
      ],
      [
        'name' => 'ZINACANTEPEC',
        'state_id' => 15
      ],
      [
        'name' => 'ZUMPAHUACÁN',
        'state_id' => 15
      ],
      [
        'name' => 'ZUMPANGO',
        'state_id' => 15
      ],
      [
        'name' => 'CUAUTITLÁN IZCALLI',
        'state_id' => 15
      ],
      [
        'name' => 'VALLE DE CHALCO SOLIDARIDAD',
        'state_id' => 15
      ],
      [
        'name' => 'LUVIANOS',
        'state_id' => 15
      ],
      [
        'name' => 'SAN JOSÉ DEL RINCÓN',
        'state_id' => 15
      ],
      [
        'name' => 'TONANITLA',
        'state_id' => 15
      ],
      [
        'name' => 'ACUITZIO',
        'state_id' => 16
      ],
      [
        'name' => 'AGUILILLA',
        'state_id' => 16
      ],
      [
        'name' => 'ÁLVARO OBREGÓN',
        'state_id' => 16
      ],
      [
        'name' => 'ANGAMACUTIRO',
        'state_id' => 16
      ],
      [
        'name' => 'ANGANGUEO',
        'state_id' => 16
      ],
      [
        'name' => 'APATZINGÁN',
        'state_id' => 16
      ],
      [
        'name' => 'APORO',
        'state_id' => 16
      ],
      [
        'name' => 'AQUILA',
        'state_id' => 16
      ],
      [
        'name' => 'ARIO',
        'state_id' => 16
      ],
      [
        'name' => 'ARTEAGA',
        'state_id' => 16
      ],
      [
        'name' => 'BRISEÑAS',
        'state_id' => 16
      ],
      [
        'name' => 'BUENAVISTA',
        'state_id' => 16
      ],
      [
        'name' => 'CARÁCUARO',
        'state_id' => 16
      ],
      [
        'name' => 'COAHUAYANA',
        'state_id' => 16
      ],
      [
        'name' => 'COALCOMÁN DE VÁZQUEZ PALLARES',
        'state_id' => 16
      ],
      [
        'name' => 'COENEO',
        'state_id' => 16
      ],
      [
        'name' => 'CONTEPEC',
        'state_id' => 16
      ],
      [
        'name' => 'COPÁNDARO',
        'state_id' => 16
      ],
      [
        'name' => 'COTIJA',
        'state_id' => 16
      ],
      [
        'name' => 'CUITZEO',
        'state_id' => 16
      ],
      [
        'name' => 'CHARAPAN',
        'state_id' => 16
      ],
      [
        'name' => 'CHARO',
        'state_id' => 16
      ],
      [
        'name' => 'CHAVINDA',
        'state_id' => 16
      ],
      [
        'name' => 'CHERÁN',
        'state_id' => 16
      ],
      [
        'name' => 'CHILCHOTA',
        'state_id' => 16
      ],
      [
        'name' => 'CHINICUILA',
        'state_id' => 16
      ],
      [
        'name' => 'CHUCÁNDIRO',
        'state_id' => 16
      ],
      [
        'name' => 'CHURINTZIO',
        'state_id' => 16
      ],
      [
        'name' => 'CHURUMUCO',
        'state_id' => 16
      ],
      [
        'name' => 'ECUANDUREO',
        'state_id' => 16
      ],
      [
        'name' => 'EPITACIO HUERTA',
        'state_id' => 16
      ],
      [
        'name' => 'ERONGARÍCUARO',
        'state_id' => 16
      ],
      [
        'name' => 'GABRIEL ZAMORA',
        'state_id' => 16
      ],
      [
        'name' => 'HIDALGO',
        'state_id' => 16
      ],
      [
        'name' => 'LA HUACANA',
        'state_id' => 16
      ],
      [
        'name' => 'HUANDACAREO',
        'state_id' => 16
      ],
      [
        'name' => 'HUANIQUEO',
        'state_id' => 16
      ],
      [
        'name' => 'HUETAMO',
        'state_id' => 16
      ],
      [
        'name' => 'HUIRAMBA',
        'state_id' => 16
      ],
      [
        'name' => 'INDAPARAPEO',
        'state_id' => 16
      ],
      [
        'name' => 'IRIMBO',
        'state_id' => 16
      ],
      [
        'name' => 'IXTLÁN',
        'state_id' => 16
      ],
      [
        'name' => 'JACONA',
        'state_id' => 16
      ],
      [
        'name' => 'JIMÉNEZ',
        'state_id' => 16
      ],
      [
        'name' => 'JIQUILPAN',
        'state_id' => 16
      ],
      [
        'name' => 'JUÁREZ',
        'state_id' => 16
      ],
      [
        'name' => 'JUNGAPEO',
        'state_id' => 16
      ],
      [
        'name' => 'LAGUNILLAS',
        'state_id' => 16
      ],
      [
        'name' => 'MADERO',
        'state_id' => 16
      ],
      [
        'name' => 'MARAVATÍO',
        'state_id' => 16
      ],
      [
        'name' => 'MARCOS CASTELLANOS',
        'state_id' => 16
      ],
      [
        'name' => 'LÁZARO CÁRDENAS',
        'state_id' => 16
      ],
      [
        'name' => 'MORELIA',
        'state_id' => 16
      ],
      [
        'name' => 'MORELOS',
        'state_id' => 16
      ],
      [
        'name' => 'MÚGICA',
        'state_id' => 16
      ],
      [
        'name' => 'NAHUATZEN',
        'state_id' => 16
      ],
      [
        'name' => 'NOCUPÉTARO',
        'state_id' => 16
      ],
      [
        'name' => 'NUEVO PARANGARICUTIRO',
        'state_id' => 16
      ],
      [
        'name' => 'NUEVO URECHO',
        'state_id' => 16
      ],
      [
        'name' => 'NUMARÁN',
        'state_id' => 16
      ],
      [
        'name' => 'OCAMPO',
        'state_id' => 16
      ],
      [
        'name' => 'PAJACUARÁN',
        'state_id' => 16
      ],
      [
        'name' => 'PANINDÍCUARO',
        'state_id' => 16
      ],
      [
        'name' => 'PARÁCUARO',
        'state_id' => 16
      ],
      [
        'name' => 'PARACHO',
        'state_id' => 16
      ],
      [
        'name' => 'PÁTZCUARO',
        'state_id' => 16
      ],
      [
        'name' => 'PENJAMILLO',
        'state_id' => 16
      ],
      [
        'name' => 'PERIBÁN',
        'state_id' => 16
      ],
      [
        'name' => 'LA PIEDAD',
        'state_id' => 16
      ],
      [
        'name' => 'PURÉPERO',
        'state_id' => 16
      ],
      [
        'name' => 'PURUÁNDIRO',
        'state_id' => 16
      ],
      [
        'name' => 'QUERÉNDARO',
        'state_id' => 16
      ],
      [
        'name' => 'QUIROGA',
        'state_id' => 16
      ],
      [
        'name' => 'COJUMATLÁN DE RÉGULES',
        'state_id' => 16
      ],
      [
        'name' => 'LOS REYES',
        'state_id' => 16
      ],
      [
        'name' => 'SAHUAYO',
        'state_id' => 16
      ],
      [
        'name' => 'SAN LUCAS',
        'state_id' => 16
      ],
      [
        'name' => 'SANTA ANA MAYA',
        'state_id' => 16
      ],
      [
        'name' => 'SALVADOR ESCALANTE',
        'state_id' => 16
      ],
      [
        'name' => 'SENGUIO',
        'state_id' => 16
      ],
      [
        'name' => 'SUSUPUATO',
        'state_id' => 16
      ],
      [
        'name' => 'TACÁMBARO',
        'state_id' => 16
      ],
      [
        'name' => 'TANCÍTARO',
        'state_id' => 16
      ],
      [
        'name' => 'TANGAMANDAPIO',
        'state_id' => 16
      ],
      [
        'name' => 'TANGANCÍCUARO',
        'state_id' => 16
      ],
      [
        'name' => 'TANHUATO',
        'state_id' => 16
      ],
      [
        'name' => 'TARETAN',
        'state_id' => 16
      ],
      [
        'name' => 'TARÍMBARO',
        'state_id' => 16
      ],
      [
        'name' => 'TEPALCATEPEC',
        'state_id' => 16
      ],
      [
        'name' => 'TINGAMBATO',
        'state_id' => 16
      ],
      [
        'name' => 'TINGÜINDÍN',
        'state_id' => 16
      ],
      [
        'name' => 'TIQUICHEO DE NICOLÁS ROMERO',
        'state_id' => 16
      ],
      [
        'name' => 'TLALPUJAHUA',
        'state_id' => 16
      ],
      [
        'name' => 'TLAZAZALCA',
        'state_id' => 16
      ],
      [
        'name' => 'TOCUMBO',
        'state_id' => 16
      ],
      [
        'name' => 'TUMBISCATÍO',
        'state_id' => 16
      ],
      [
        'name' => 'TURICATO',
        'state_id' => 16
      ],
      [
        'name' => 'TUXPAN',
        'state_id' => 16
      ],
      [
        'name' => 'TUZANTLA',
        'state_id' => 16
      ],
      [
        'name' => 'TZINTZUNTZAN',
        'state_id' => 16
      ],
      [
        'name' => 'TZITZIO',
        'state_id' => 16
      ],
      [
        'name' => 'URUAPAN',
        'state_id' => 16
      ],
      [
        'name' => 'VENUSTIANO CARRANZA',
        'state_id' => 16
      ],
      [
        'name' => 'VILLAMAR',
        'state_id' => 16
      ],
      [
        'name' => 'VISTA HERMOSA',
        'state_id' => 16
      ],
      [
        'name' => 'YURÉCUARO',
        'state_id' => 16
      ],
      [
        'name' => 'ZACAPU',
        'state_id' => 16
      ],
      [
        'name' => 'ZAMORA',
        'state_id' => 16
      ],
      [
        'name' => 'ZINÁPARO',
        'state_id' => 16
      ],
      [
        'name' => 'ZINAPÉCUARO',
        'state_id' => 16
      ],
      [
        'name' => 'ZIRACUARETIRO',
        'state_id' => 16
      ],
      [
        'name' => 'ZITÁCUARO',
        'state_id' => 16
      ],
      [
        'name' => 'JOSÉ SIXTO VERDUZCO',
        'state_id' => 16
      ],
      [
        'name' => 'AMACUZAC',
        'state_id' => 17
      ],
      [
        'name' => 'ATLATLAHUCAN',
        'state_id' => 17
      ],
      [
        'name' => 'AXOCHIAPAN',
        'state_id' => 17
      ],
      [
        'name' => 'AYALA',
        'state_id' => 17
      ],
      [
        'name' => 'COATLÁN DEL RÍO',
        'state_id' => 17
      ],
      [
        'name' => 'CUAUTLA',
        'state_id' => 17
      ],
      [
        'name' => 'CUERNAVACA',
        'state_id' => 17
      ],
      [
        'name' => 'EMILIANO ZAPATA',
        'state_id' => 17
      ],
      [
        'name' => 'HUITZILAC',
        'state_id' => 17
      ],
      [
        'name' => 'JANTETELCO',
        'state_id' => 17
      ],
      [
        'name' => 'JIUTEPEC',
        'state_id' => 17
      ],
      [
        'name' => 'JOJUTLA',
        'state_id' => 17
      ],
      [
        'name' => 'JONACATEPEC DE LEANDRO VALLE',
        'state_id' => 17
      ],
      [
        'name' => 'MAZATEPEC',
        'state_id' => 17
      ],
      [
        'name' => 'MIACATLÁN',
        'state_id' => 17
      ],
      [
        'name' => 'OCUITUCO',
        'state_id' => 17
      ],
      [
        'name' => 'PUENTE DE IXTLA',
        'state_id' => 17
      ],
      [
        'name' => 'TEMIXCO',
        'state_id' => 17
      ],
      [
        'name' => 'TEPALCINGO',
        'state_id' => 17
      ],
      [
        'name' => 'TEPOZTLÁN',
        'state_id' => 17
      ],
      [
        'name' => 'TETECALA',
        'state_id' => 17
      ],
      [
        'name' => 'TETELA DEL VOLCÁN',
        'state_id' => 17
      ],
      [
        'name' => 'TLALNEPANTLA',
        'state_id' => 17
      ],
      [
        'name' => 'TLALTIZAPÁN DE ZAPATA',
        'state_id' => 17
      ],
      [
        'name' => 'TLAQUILTENANGO',
        'state_id' => 17
      ],
      [
        'name' => 'TLAYACAPAN',
        'state_id' => 17
      ],
      [
        'name' => 'TOTOLAPAN',
        'state_id' => 17
      ],
      [
        'name' => 'XOCHITEPEC',
        'state_id' => 17
      ],
      [
        'name' => 'YAUTEPEC',
        'state_id' => 17
      ],
      [
        'name' => 'YECAPIXTLA',
        'state_id' => 17
      ],
      [
        'name' => 'ZACATEPEC',
        'state_id' => 17
      ],
      [
        'name' => 'ZACUALPAN DE AMILPAS',
        'state_id' => 17
      ],
      [
        'name' => 'TEMOAC',
        'state_id' => 17
      ],
      [
        'name' => 'COATETELCO',
        'state_id' => 17
      ],
      [
        'name' => 'XOXOCOTLA',
        'state_id' => 17
      ],
      [
        'name' => 'HUEYAPAN',
        'state_id' => 17
      ],
      [
        'name' => 'ACAPONETA',
        'state_id' => 18
      ],
      [
        'name' => 'AHUACATLÁN',
        'state_id' => 18
      ],
      [
        'name' => 'AMATLÁN DE CAÑAS',
        'state_id' => 18
      ],
      [
        'name' => 'COMPOSTELA',
        'state_id' => 18
      ],
      [
        'name' => 'HUAJICORI',
        'state_id' => 18
      ],
      [
        'name' => 'IXTLÁN DEL RÍO',
        'state_id' => 18
      ],
      [
        'name' => 'JALA',
        'state_id' => 18
      ],
      [
        'name' => 'XALISCO',
        'state_id' => 18
      ],
      [
        'name' => 'DEL NAYAR',
        'state_id' => 18
      ],
      [
        'name' => 'ROSAMORADA',
        'state_id' => 18
      ],
      [
        'name' => 'RUÍZ',
        'state_id' => 18
      ],
      [
        'name' => 'SAN BLAS',
        'state_id' => 18
      ],
      [
        'name' => 'SAN PEDRO LAGUNILLAS',
        'state_id' => 18
      ],
      [
        'name' => 'SANTA MARÍA DEL ORO',
        'state_id' => 18
      ],
      [
        'name' => 'SANTIAGO IXCUINTLA',
        'state_id' => 18
      ],
      [
        'name' => 'TECUALA',
        'state_id' => 18
      ],
      [
        'name' => 'TEPIC',
        'state_id' => 18
      ],
      [
        'name' => 'TUXPAN',
        'state_id' => 18
      ],
      [
        'name' => 'LA YESCA',
        'state_id' => 18
      ],
      [
        'name' => 'BAHÍA DE BANDERAS',
        'state_id' => 18
      ],
      [
        'name' => 'ABASOLO',
        'state_id' => 19
      ],
      [
        'name' => 'AGUALEGUAS',
        'state_id' => 19
      ],
      [
        'name' => 'LOS ALDAMAS',
        'state_id' => 19
      ],
      [
        'name' => 'ALLENDE',
        'state_id' => 19
      ],
      [
        'name' => 'ANÁHUAC',
        'state_id' => 19
      ],
      [
        'name' => 'APODACA',
        'state_id' => 19
      ],
      [
        'name' => 'ARAMBERRI',
        'state_id' => 19
      ],
      [
        'name' => 'BUSTAMANTE',
        'state_id' => 19
      ],
      [
        'name' => 'CADEREYTA JIMÉNEZ',
        'state_id' => 19
      ],
      [
        'name' => 'EL CARMEN',
        'state_id' => 19
      ],
      [
        'name' => 'CERRALVO',
        'state_id' => 19
      ],
      [
        'name' => 'CIÉNEGA DE FLORES',
        'state_id' => 19
      ],
      [
        'name' => 'CHINA',
        'state_id' => 19
      ],
      [
        'name' => 'DOCTOR ARROYO',
        'state_id' => 19
      ],
      [
        'name' => 'DOCTOR COSS',
        'state_id' => 19
      ],
      [
        'name' => 'DOCTOR GONZÁLEZ',
        'state_id' => 19
      ],
      [
        'name' => 'GALEANA',
        'state_id' => 19
      ],
      [
        'name' => 'GARCÍA',
        'state_id' => 19
      ],
      [
        'name' => 'SAN PEDRO GARZA GARCÍA',
        'state_id' => 19
      ],
      [
        'name' => 'GENERAL BRAVO',
        'state_id' => 19
      ],
      [
        'name' => 'GENERAL ESCOBEDO',
        'state_id' => 19
      ],
      [
        'name' => 'GENERAL TERÁN',
        'state_id' => 19
      ],
      [
        'name' => 'GENERAL TREVIÑO',
        'state_id' => 19
      ],
      [
        'name' => 'GENERAL ZARAGOZA',
        'state_id' => 19
      ],
      [
        'name' => 'GENERAL ZUAZUA',
        'state_id' => 19
      ],
      [
        'name' => 'GUADALUPE',
        'state_id' => 19
      ],
      [
        'name' => 'LOS HERRERAS',
        'state_id' => 19
      ],
      [
        'name' => 'HIGUERAS',
        'state_id' => 19
      ],
      [
        'name' => 'HUALAHUISES',
        'state_id' => 19
      ],
      [
        'name' => 'ITURBIDE',
        'state_id' => 19
      ],
      [
        'name' => 'JUÁREZ',
        'state_id' => 19
      ],
      [
        'name' => 'LAMPAZOS DE NARANJO',
        'state_id' => 19
      ],
      [
        'name' => 'LINARES',
        'state_id' => 19
      ],
      [
        'name' => 'MARÍN',
        'state_id' => 19
      ],
      [
        'name' => 'MELCHOR OCAMPO',
        'state_id' => 19
      ],
      [
        'name' => 'MIER Y NORIEGA',
        'state_id' => 19
      ],
      [
        'name' => 'MINA',
        'state_id' => 19
      ],
      [
        'name' => 'MONTEMORELOS',
        'state_id' => 19
      ],
      [
        'name' => 'MONTERREY',
        'state_id' => 19
      ],
      [
        'name' => 'PARÁS',
        'state_id' => 19
      ],
      [
        'name' => 'PESQUERÍA',
        'state_id' => 19
      ],
      [
        'name' => 'LOS RAMONES',
        'state_id' => 19
      ],
      [
        'name' => 'RAYONES',
        'state_id' => 19
      ],
      [
        'name' => 'SABINAS HIDALGO',
        'state_id' => 19
      ],
      [
        'name' => 'SALINAS VICTORIA',
        'state_id' => 19
      ],
      [
        'name' => 'SAN NICOLÁS DE LOS GARZA',
        'state_id' => 19
      ],
      [
        'name' => 'HIDALGO',
        'state_id' => 19
      ],
      [
        'name' => 'SANTA CATARINA',
        'state_id' => 19
      ],
      [
        'name' => 'SANTIAGO',
        'state_id' => 19
      ],
      [
        'name' => 'VALLECILLO',
        'state_id' => 19
      ],
      [
        'name' => 'VILLALDAMA',
        'state_id' => 19
      ],
      [
        'name' => 'ABEJONES',
        'state_id' => 20
      ],
      [
        'name' => 'ACATLÁN DE PÉREZ FIGUEROA',
        'state_id' => 20
      ],
      [
        'name' => 'ASUNCIÓN CACALOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'ASUNCIÓN CUYOTEPEJI',
        'state_id' => 20
      ],
      [
        'name' => 'ASUNCIÓN IXTALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'ASUNCIÓN NOCHIXTLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'ASUNCIÓN OCOTLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'ASUNCIÓN TLACOLULITA',
        'state_id' => 20
      ],
      [
        'name' => 'AYOTZINTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'EL BARRIO DE LA SOLEDAD',
        'state_id' => 20
      ],
      [
        'name' => 'CALIHUALÁ',
        'state_id' => 20
      ],
      [
        'name' => 'CANDELARIA LOXICHA',
        'state_id' => 20
      ],
      [
        'name' => 'CIÉNEGA DE ZIMATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'CIUDAD IXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'COATECAS ALTAS',
        'state_id' => 20
      ],
      [
        'name' => 'COICOYÁN DE LAS FLORES',
        'state_id' => 20
      ],
      [
        'name' => 'LA COMPAÑÍA',
        'state_id' => 20
      ],
      [
        'name' => 'CONCEPCIÓN BUENAVISTA',
        'state_id' => 20
      ],
      [
        'name' => 'CONCEPCIÓN PÁPALO',
        'state_id' => 20
      ],
      [
        'name' => 'CONSTANCIA DEL ROSARIO',
        'state_id' => 20
      ],
      [
        'name' => 'COSOLAPA',
        'state_id' => 20
      ],
      [
        'name' => 'COSOLTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'CUILÁPAM DE GUERRERO',
        'state_id' => 20
      ],
      [
        'name' => 'CUYAMECALCO VILLA DE ZARAGOZA',
        'state_id' => 20
      ],
      [
        'name' => 'CHAHUITES',
        'state_id' => 20
      ],
      [
        'name' => 'CHALCATONGO DE HIDALGO',
        'state_id' => 20
      ],
      [
        'name' => 'CHIQUIHUITLÁN DE BENITO JUÁREZ',
        'state_id' => 20
      ],
      [
        'name' => 'HEROICA CIUDAD DE EJUTLA DE CRESPO',
        'state_id' => 20
      ],
      [
        'name' => 'ELOXOCHITLÁN DE FLORES MAGÓN',
        'state_id' => 20
      ],
      [
        'name' => 'EL ESPINAL',
        'state_id' => 20
      ],
      [
        'name' => 'TAMAZULÁPAM DEL ESPÍRITU SANTO',
        'state_id' => 20
      ],
      [
        'name' => 'FRESNILLO DE TRUJANO',
        'state_id' => 20
      ],
      [
        'name' => 'GUADALUPE ETLA',
        'state_id' => 20
      ],
      [
        'name' => 'GUADALUPE DE RAMÍREZ',
        'state_id' => 20
      ],
      [
        'name' => 'GUELATAO DE JUÁREZ',
        'state_id' => 20
      ],
      [
        'name' => 'GUEVEA DE HUMBOLDT',
        'state_id' => 20
      ],
      [
        'name' => 'MESONES HIDALGO',
        'state_id' => 20
      ],
      [
        'name' => 'VILLA HIDALGO',
        'state_id' => 20
      ],
      [
        'name' => 'HEROICA CIUDAD DE HUAJUAPAN DE LEÓN',
        'state_id' => 20
      ],
      [
        'name' => 'HUAUTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'HUAUTLA DE JIMÉNEZ',
        'state_id' => 20
      ],
      [
        'name' => 'IXTLÁN DE JUÁREZ',
        'state_id' => 20
      ],
      [
        'name' => 'JUCHITÁN DE ZARAGOZA',
        'state_id' => 20
      ],
      [
        'name' => 'LOMA BONITA',
        'state_id' => 20
      ],
      [
        'name' => 'MAGDALENA APASCO',
        'state_id' => 20
      ],
      [
        'name' => 'MAGDALENA JALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MAGDALENA JICOTLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'MAGDALENA MIXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'MAGDALENA OCOTLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'MAGDALENA PEÑASCO',
        'state_id' => 20
      ],
      [
        'name' => 'MAGDALENA TEITIPAC',
        'state_id' => 20
      ],
      [
        'name' => 'MAGDALENA TEQUISISTLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'MAGDALENA TLACOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'MAGDALENA ZAHUATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'MARISCALA DE JUÁREZ',
        'state_id' => 20
      ],
      [
        'name' => 'MÁRTIRES DE TACUBAYA',
        'state_id' => 20
      ],
      [
        'name' => 'MATÍAS ROMERO AVENDAÑO',
        'state_id' => 20
      ],
      [
        'name' => 'MAZATLÁN VILLA DE FLORES',
        'state_id' => 20
      ],
      [
        'name' => 'MIAHUATLÁN DE PORFIRIO DÍAZ',
        'state_id' => 20
      ],
      [
        'name' => 'MIXISTLÁN DE LA REFORMA',
        'state_id' => 20
      ],
      [
        'name' => 'MONJAS',
        'state_id' => 20
      ],
      [
        'name' => 'NATIVIDAD',
        'state_id' => 20
      ],
      [
        'name' => 'NAZARENO ETLA',
        'state_id' => 20
      ],
      [
        'name' => 'NEJAPA DE MADERO',
        'state_id' => 20
      ],
      [
        'name' => 'IXPANTEPEC NIEVES',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO NILTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'OAXACA DE JUÁREZ',
        'state_id' => 20
      ],
      [
        'name' => 'OCOTLÁN DE MORELOS',
        'state_id' => 20
      ],
      [
        'name' => 'LA PE',
        'state_id' => 20
      ],
      [
        'name' => 'PINOTEPA DE DON LUIS',
        'state_id' => 20
      ],
      [
        'name' => 'PLUMA HIDALGO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JOSÉ DEL PROGRESO',
        'state_id' => 20
      ],
      [
        'name' => 'PUTLA VILLA DE GUERRERO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CATARINA QUIOQUITANI',
        'state_id' => 20
      ],
      [
        'name' => 'REFORMA DE PINEDA',
        'state_id' => 20
      ],
      [
        'name' => 'LA REFORMA',
        'state_id' => 20
      ],
      [
        'name' => 'REYES ETLA',
        'state_id' => 20
      ],
      [
        'name' => 'ROJAS DE CUAUHTÉMOC',
        'state_id' => 20
      ],
      [
        'name' => 'SALINA CRUZ',
        'state_id' => 20
      ],
      [
        'name' => 'SAN AGUSTÍN AMATENGO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN AGUSTÍN ATENANGO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN AGUSTÍN CHAYUCO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN AGUSTÍN DE LAS JUNTAS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN AGUSTÍN ETLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN AGUSTÍN LOXICHA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN AGUSTÍN TLACOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN AGUSTÍN YATARENI',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS CABECERA NUEVA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS DINICUITI',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS HUAXPALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS HUAYÁPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS IXTLAHUACA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS LAGUNAS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS NUXIÑO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS PAXTLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS SINAXTLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS SOLAGA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS TEOTILÁLPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS TEPETLAPA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS YAÁ',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS ZABACHE',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANDRÉS ZAUTLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANTONINO CASTILLO VELASCO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANTONINO EL ALTO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANTONINO MONTE VERDE',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANTONIO ACUTLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANTONIO DE LA CAL',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANTONIO HUITEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANTONIO NANAHUATÍPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANTONIO SINICAHUA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ANTONIO TEPETLAPA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN BALTAZAR CHICHICÁPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SAN BALTAZAR LOXICHA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN BALTAZAR YATZACHI EL BAJO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN BARTOLO COYOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN BARTOLOMÉ AYAUTLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN BARTOLOMÉ LOXICHA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN BARTOLOMÉ QUIALANA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN BARTOLOMÉ YUCUAÑE',
        'state_id' => 20
      ],
      [
        'name' => 'SAN BARTOLOMÉ ZOOGOCHO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN BARTOLO SOYALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN BARTOLO YAUTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN BERNARDO MIXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN BLAS ATEMPA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN CARLOS YAUTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN CRISTÓBAL AMATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN CRISTÓBAL AMOLTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN CRISTÓBAL LACHIRIOAG',
        'state_id' => 20
      ],
      [
        'name' => 'SAN CRISTÓBAL SUCHIXTLAHUACA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN DIONISIO DEL MAR',
        'state_id' => 20
      ],
      [
        'name' => 'SAN DIONISIO OCOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN DIONISIO OCOTLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ESTEBAN ATATLAHUCA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FELIPE JALAPA DE DÍAZ',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FELIPE TEJALÁPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FELIPE USILA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO CAHUACUÁ',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO CAJONOS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO CHAPULAPA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO CHINDÚA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO DEL MAR',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO HUEHUETLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO IXHUATÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO JALTEPETONGO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO LACHIGOLÓ',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO LOGUECHE',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO NUXAÑO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO OZOLOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO SOLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO TELIXTLAHUACA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO TEOPAN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN FRANCISCO TLAPANCINGO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN GABRIEL MIXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ILDEFONSO AMATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ILDEFONSO SOLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN ILDEFONSO VILLA ALTA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JACINTO AMILPAS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JACINTO TLACOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JERÓNIMO COATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JERÓNIMO SILACAYOAPILLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JERÓNIMO SOSOLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JERÓNIMO TAVICHE',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JERÓNIMO TECÓATL',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JORGE NUCHITA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JOSÉ AYUQUILA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JOSÉ CHILTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JOSÉ DEL PEÑASCO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JOSÉ ESTANCIA GRANDE',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JOSÉ INDEPENDENCIA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JOSÉ LACHIGUIRI',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JOSÉ TENANGO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN ACHIUTLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN ATEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'ÁNIMAS TRUJANO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN BAUTISTA ATATLAHUCA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN BAUTISTA COIXTLAHUACA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN BAUTISTA CUICATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN BAUTISTA GUELACHE',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN BAUTISTA JAYACATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN BAUTISTA LO DE SOTO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN BAUTISTA SUCHITEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN BAUTISTA TLACOATZINTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN BAUTISTA TLACHICHILCO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN BAUTISTA TUXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN CACAHUATEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN CIENEGUILLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN COATZÓSPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN COLORADO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN COMALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN COTZOCÓN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN CHICOMEZÚCHIL',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN CHILATECA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN DEL ESTADO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN DEL RÍO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN DIUXI',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN EVANGELISTA ANALCO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN GUELAVÍA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN GUICHICOVI',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN IHUALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN JUQUILA MIXES',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN JUQUILA VIJANOS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN LACHAO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN LACHIGALLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN LAJARCIA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN LALANA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN DE LOS CUÉS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN MAZATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN MIXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN MIXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN ÑUMÍ',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN OZOLOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN PETLAPA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN QUIAHIJE',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN QUIOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN SAYULTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN TABAÁ',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN TAMAZOLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN TEITA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN TEITIPAC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN TEPEUXILA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN TEPOSCOLULA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN YAEÉ',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN YATZONA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN YUCUITA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN LORENZO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN LORENZO ALBARRADAS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN LORENZO CACAOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN LORENZO CUAUNECUILTITLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN LORENZO TEXMELÚCAN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN LORENZO VICTORIA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN LUCAS CAMOTLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN LUCAS OJITLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN LUCAS QUIAVINÍ',
        'state_id' => 20
      ],
      [
        'name' => 'SAN LUCAS ZOQUIÁPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SAN LUIS AMATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MARCIAL OZOLOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MARCOS ARTEAGA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MARTÍN DE LOS CANSECOS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MARTÍN HUAMELÚLPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MARTÍN ITUNYOSO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MARTÍN LACHILÁ',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MARTÍN PERAS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MARTÍN TILCAJETE',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MARTÍN TOXPALAN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MARTÍN ZACATEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MATEO CAJONOS',
        'state_id' => 20
      ],
      [
        'name' => 'CAPULÁLPAM DE MÉNDEZ',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MATEO DEL MAR',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MATEO YOLOXOCHITLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MATEO ETLATONGO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MATEO NEJÁPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MATEO PEÑASCO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MATEO PIÑAS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MATEO RÍO HONDO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MATEO SINDIHUI',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MATEO TLAPILTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MELCHOR BETAZA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL ACHIUTLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL AHUEHUETITLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL ALOÁPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL AMATITLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL AMATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL COATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL CHICAHUA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL CHIMALAPA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL DEL PUERTO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL DEL RÍO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL EJUTLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL EL GRANDE',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL HUAUTLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL MIXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL PANIXTLAHUACA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL PERAS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL PIEDRAS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL QUETZALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL SANTA FLOR',
        'state_id' => 20
      ],
      [
        'name' => 'VILLA SOLA DE VEGA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL SOYALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL SUCHIXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'VILLA TALEA DE CASTRO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL TECOMATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL TENANGO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL TEQUIXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL TILQUIÁPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL TLACAMAMA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL TLACOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL TULANCINGO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MIGUEL YOTAO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN NICOLÁS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN NICOLÁS HIDALGO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PABLO COATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PABLO CUATRO VENADOS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PABLO ETLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PABLO HUITZO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PABLO HUIXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PABLO MACUILTIANGUIS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PABLO TIJALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PABLO VILLA DE MITLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PABLO YAGANIZA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO AMUZGOS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO APÓSTOL',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO ATOYAC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO CAJONOS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO COXCALTEPEC CÁNTAROS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO COMITANCILLO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO EL ALTO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO HUAMELULA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO HUILOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO IXCATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO IXTLAHUACA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO JALTEPETONGO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO JICAYÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO JOCOTIPAC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO JUCHATENGO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO MÁRTIR',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO MÁRTIR QUIECHAPA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO MÁRTIR YUCUXACO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO MIXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO MIXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO MOLINOS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO NOPALA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO OCOPETATILLO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO OCOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO POCHUTLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO QUIATONI',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO SOCHIÁPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO TAPANATEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO TAVICHE',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO TEOZACOALCO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO TEUTILA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO TIDAÁ',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO TOPILTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO TOTOLÁPAM',
        'state_id' => 20
      ],
      [
        'name' => 'VILLA DE TUTUTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO YANERI',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO YÓLOX',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO Y SAN PABLO AYUTLA',
        'state_id' => 20
      ],
      [
        'name' => 'VILLA DE ETLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO Y SAN PABLO TEPOSCOLULA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO Y SAN PABLO TEQUIXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN PEDRO YUCUNAMA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN RAYMUNDO JALPAN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN SEBASTIÁN ABASOLO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN SEBASTIÁN COATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN SEBASTIÁN IXCAPA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN SEBASTIÁN NICANANDUTA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN SEBASTIÁN RÍO HONDO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN SEBASTIÁN TECOMAXTLAHUACA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN SEBASTIÁN TEITIPAC',
        'state_id' => 20
      ],
      [
        'name' => 'SAN SEBASTIÁN TUTLA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN SIMÓN ALMOLONGAS',
        'state_id' => 20
      ],
      [
        'name' => 'SAN SIMÓN ZAHUATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA ANA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA ANA ATEIXTLAHUACA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA ANA CUAUHTÉMOC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA ANA DEL VALLE',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA ANA TAVELA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA ANA TLAPACOYAN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA ANA YARENI',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA ANA ZEGACHE',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CATALINA QUIERÍ',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CATARINA CUIXTLA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CATARINA IXTEPEJI',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CATARINA JUQUILA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CATARINA LACHATAO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CATARINA LOXICHA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CATARINA MECHOACÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CATARINA MINAS',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CATARINA QUIANÉ',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CATARINA TAYATA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CATARINA TICUÁ',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CATARINA YOSONOTÚ',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CATARINA ZAPOQUILA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CRUZ ACATEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CRUZ AMILPAS',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CRUZ DE BRAVO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CRUZ ITUNDUJIA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CRUZ MIXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CRUZ NUNDACO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CRUZ PAPALUTLA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CRUZ TACACHE DE MINA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CRUZ TACAHUA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CRUZ TAYATA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CRUZ XITLA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CRUZ XOXOCOTLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA CRUZ ZENZONTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA GERTRUDIS',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA INÉS DEL MONTE',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA INÉS YATZECHE',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA LUCÍA DEL CAMINO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA LUCÍA MIAHUATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA LUCÍA MONTEVERDE',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA LUCÍA OCOTLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA ALOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA APAZCO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA LA ASUNCIÓN',
        'state_id' => 20
      ],
      [
        'name' => 'HEROICA CIUDAD DE TLAXIACO',
        'state_id' => 20
      ],
      [
        'name' => 'AYOQUEZCO DE ALDAMA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA ATZOMPA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA CAMOTLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA COLOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA CORTIJO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA COYOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA CHACHOÁPAM',
        'state_id' => 20
      ],
      [
        'name' => 'VILLA DE CHILAPA DE DÍAZ',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA CHILCHOTLA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA CHIMALAPA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA DEL ROSARIO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA DEL TULE',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA ECATEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA GUELACÉ',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA GUIENAGATI',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA HUATULCO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA HUAZOLOTITLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA IPALAPA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA IXCATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA JACATEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA JALAPA DEL MARQUÉS',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA JALTIANGUIS',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA LACHIXÍO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA MIXTEQUILLA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA NATIVITAS',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA NDUAYACO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA OZOLOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA PÁPALO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA PEÑOLES',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA PETAPA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA QUIEGOLANI',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA SOLA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA TATALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA TECOMAVACA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA TEMAXCALAPA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA TEMAXCALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA TEOPOXCO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA TEPANTLALI',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA TEXCATITLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA TLAHUITOLTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA TLALIXTAC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA TOnameCA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA TOTOLAPILLA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA XADANI',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA YALINA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA YAVESÍA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA YOLOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA YOSOYÚA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA YUCUHITI',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA ZACATEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA ZANIZA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA MARÍA ZOQUITLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO AMOLTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO APOALA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO APÓSTOL',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO ASTATA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO ATITLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO AYUQUILILLA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO CACALOXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO CAMOTLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO COMALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'VILLA DE SANTIAGO CHAZUMBA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO CHOÁPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO DEL RÍO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO HUAJOLOTITLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO HUAUCLILLA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO IHUITLÁN PLUMAS',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO IXCUINTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO IXTAYUTLA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO JAMILTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO JOCOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO JUXTLAHUACA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO LACHIGUIRI',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO LALOPA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO LAOLLAGA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO LAXOPA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO LLANO GRANDE',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO MATATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO MILTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO MINAS',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO NACALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO NEJAPILLA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO NUNDICHE',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO NUYOÓ',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO PINOTEPA NACIONAL',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO SUCHILQUITONGO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO TAMAZOLA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO TAPEXTLA',
        'state_id' => 20
      ],
      [
        'name' => 'VILLA TEJÚPAM DE LA UNIÓN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO TENANGO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO TEPETLAPA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO TETEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO TEXCALCINGO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO TEXTITLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO TILANTONGO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO TILLO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO TLAZOYALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO XANICA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO XIACUÍ',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO YAITEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO YAVEO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO YOLOMÉCATL',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO YOSONDÚA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO YUCUYACHI',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO ZACATEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTIAGO ZOOCHILA',
        'state_id' => 20
      ],
      [
        'name' => 'NUEVO ZOQUIÁPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO INGENIO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO ALBARRADAS',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO ARMENTA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO CHIHUITÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO DE MORELOS',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO IXCATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO NUXAÁ',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO OZOLOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO PETAPA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO ROAYAGA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO TEHUANTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO TEOJOMULCO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO TEPUXTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO TLATAYÁPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO TOMALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO TONALÁ',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO TONALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO XAGACÍA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO YANHUITLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO YODOHINO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO DOMINGO ZANATEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTOS REYES NOPALA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTOS REYES PÁPALO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTOS REYES TEPEJILLO',
        'state_id' => 20
      ],
      [
        'name' => 'SANTOS REYES YUCUNÁ',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO TOMÁS JALIEZA',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO TOMÁS MAZALTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO TOMÁS OCOTEPEC',
        'state_id' => 20
      ],
      [
        'name' => 'SANTO TOMÁS TAMAZULAPAN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN VICENTE COATLÁN',
        'state_id' => 20
      ],
      [
        'name' => 'SAN VICENTE LACHIXÍO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN VICENTE NUÑÚ',
        'state_id' => 20
      ],
      [
        'name' => 'SILACAYOÁPAM',
        'state_id' => 20
      ],
      [
        'name' => 'SITIO DE XITLAPEHUA',
        'state_id' => 20
      ],
      [
        'name' => 'SOLEDAD ETLA',
        'state_id' => 20
      ],
      [
        'name' => 'VILLA DE TAMAZULÁPAM DEL PROGRESO',
        'state_id' => 20
      ],
      [
        'name' => 'TANETZE DE ZARAGOZA',
        'state_id' => 20
      ],
      [
        'name' => 'TANICHE',
        'state_id' => 20
      ],
      [
        'name' => 'TATALTEPEC DE VALDÉS',
        'state_id' => 20
      ],
      [
        'name' => 'TEOCOCUILCO DE MARCOS PÉREZ',
        'state_id' => 20
      ],
      [
        'name' => 'TEOTITLÁN DE FLORES MAGÓN',
        'state_id' => 20
      ],
      [
        'name' => 'TEOTITLÁN DEL VALLE',
        'state_id' => 20
      ],
      [
        'name' => 'TEOTONGO',
        'state_id' => 20
      ],
      [
        'name' => 'TEPELMEME VILLA DE MORELOS',
        'state_id' => 20
      ],
      [
        'name' => 'HEROICA VILLA TEZOATLÁN DE SEGURA Y LUNA, CUNA DE LA INDEPENDENCIA DE OAXACA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JERÓNIMO TLACOCHAHUAYA',
        'state_id' => 20
      ],
      [
        'name' => 'TLACOLULA DE MATAMOROS',
        'state_id' => 20
      ],
      [
        'name' => 'TLACOTEPEC PLUMAS',
        'state_id' => 20
      ],
      [
        'name' => 'TLALIXTAC DE CABRERA',
        'state_id' => 20
      ],
      [
        'name' => 'TOTONTEPEC VILLA DE MORELOS',
        'state_id' => 20
      ],
      [
        'name' => 'TRINIDAD ZAACHILA',
        'state_id' => 20
      ],
      [
        'name' => 'LA TRINIDAD VISTA HERMOSA',
        'state_id' => 20
      ],
      [
        'name' => 'UNIÓN HIDALGO',
        'state_id' => 20
      ],
      [
        'name' => 'VALERIO TRUJANO',
        'state_id' => 20
      ],
      [
        'name' => 'SAN JUAN BAUTISTA VALLE NACIONAL',
        'state_id' => 20
      ],
      [
        'name' => 'VILLA DÍAZ ORDAZ',
        'state_id' => 20
      ],
      [
        'name' => 'YAXE',
        'state_id' => 20
      ],
      [
        'name' => 'MAGDALENA YODOCONO DE PORFIRIO DÍAZ',
        'state_id' => 20
      ],
      [
        'name' => 'YOGANA',
        'state_id' => 20
      ],
      [
        'name' => 'YUTANDUCHI DE GUERRERO',
        'state_id' => 20
      ],
      [
        'name' => 'VILLA DE ZAACHILA',
        'state_id' => 20
      ],
      [
        'name' => 'SAN MATEO YUCUTINDOO',
        'state_id' => 20
      ],
      [
        'name' => 'ZAPOTITLÁN LAGUNAS',
        'state_id' => 20
      ],
      [
        'name' => 'ZAPOTITLÁN PALMAS',
        'state_id' => 20
      ],
      [
        'name' => 'SANTA INÉS DE ZARAGOZA',
        'state_id' => 20
      ],
      [
        'name' => 'ZIMATLÁN DE ÁLVAREZ',
        'state_id' => 20
      ],
      [
        'name' => 'ACAJETE',
        'state_id' => 21
      ],
      [
        'name' => 'ACATENO',
        'state_id' => 21
      ],
      [
        'name' => 'ACATLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'ACATZINGO',
        'state_id' => 21
      ],
      [
        'name' => 'ACTEOPAN',
        'state_id' => 21
      ],
      [
        'name' => 'AHUACATLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'AHUATLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'AHUAZOTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'AHUEHUETITLA',
        'state_id' => 21
      ],
      [
        'name' => 'AJALPAN',
        'state_id' => 21
      ],
      [
        'name' => 'ALBINO ZERTUCHE',
        'state_id' => 21
      ],
      [
        'name' => 'ALJOJUCA',
        'state_id' => 21
      ],
      [
        'name' => 'ALTEPEXI',
        'state_id' => 21
      ],
      [
        'name' => 'AMIXTLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'AMOZOC',
        'state_id' => 21
      ],
      [
        'name' => 'AQUIXTLA',
        'state_id' => 21
      ],
      [
        'name' => 'ATEMPAN',
        'state_id' => 21
      ],
      [
        'name' => 'ATEXCAL',
        'state_id' => 21
      ],
      [
        'name' => 'ATLIXCO',
        'state_id' => 21
      ],
      [
        'name' => 'ATOYATEMPAN',
        'state_id' => 21
      ],
      [
        'name' => 'ATZALA',
        'state_id' => 21
      ],
      [
        'name' => 'ATZITZIHUACÁN',
        'state_id' => 21
      ],
      [
        'name' => 'ATZITZINTLA',
        'state_id' => 21
      ],
      [
        'name' => 'AXUTLA',
        'state_id' => 21
      ],
      [
        'name' => 'AYOTOXCO DE GUERRERO',
        'state_id' => 21
      ],
      [
        'name' => 'CALPAN',
        'state_id' => 21
      ],
      [
        'name' => 'CALTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'CAMOCUAUTLA',
        'state_id' => 21
      ],
      [
        'name' => 'CAXHUACAN',
        'state_id' => 21
      ],
      [
        'name' => 'COATEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'COATZINGO',
        'state_id' => 21
      ],
      [
        'name' => 'COHETZALA',
        'state_id' => 21
      ],
      [
        'name' => 'COHUECAN',
        'state_id' => 21
      ],
      [
        'name' => 'CORONANGO',
        'state_id' => 21
      ],
      [
        'name' => 'COXCATLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'COYOMEAPAN',
        'state_id' => 21
      ],
      [
        'name' => 'COYOTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'CUAPIAXTLA DE MADERO',
        'state_id' => 21
      ],
      [
        'name' => 'CUAUTEMPAN',
        'state_id' => 21
      ],
      [
        'name' => 'CUAUTINCHÁN',
        'state_id' => 21
      ],
      [
        'name' => 'CUAUTLANCINGO',
        'state_id' => 21
      ],
      [
        'name' => 'CUAYUCA DE ANDRADE',
        'state_id' => 21
      ],
      [
        'name' => 'CUETZALAN DEL PROGRESO',
        'state_id' => 21
      ],
      [
        'name' => 'CUYOACO',
        'state_id' => 21
      ],
      [
        'name' => 'CHALCHICOMULA DE SESMA',
        'state_id' => 21
      ],
      [
        'name' => 'CHAPULCO',
        'state_id' => 21
      ],
      [
        'name' => 'CHIAUTLA',
        'state_id' => 21
      ],
      [
        'name' => 'CHIAUTZINGO',
        'state_id' => 21
      ],
      [
        'name' => 'CHICONCUAUTLA',
        'state_id' => 21
      ],
      [
        'name' => 'CHICHIQUILA',
        'state_id' => 21
      ],
      [
        'name' => 'CHIETLA',
        'state_id' => 21
      ],
      [
        'name' => 'CHIGMECATITLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'CHIGNAHUAPAN',
        'state_id' => 21
      ],
      [
        'name' => 'CHIGNAUTLA',
        'state_id' => 21
      ],
      [
        'name' => 'CHILA',
        'state_id' => 21
      ],
      [
        'name' => 'CHILA DE LA SAL',
        'state_id' => 21
      ],
      [
        'name' => 'HONEY',
        'state_id' => 21
      ],
      [
        'name' => 'CHILCHOTLA',
        'state_id' => 21
      ],
      [
        'name' => 'CHINANTLA',
        'state_id' => 21
      ],
      [
        'name' => 'DOMINGO ARENAS',
        'state_id' => 21
      ],
      [
        'name' => 'ELOXOCHITLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'EPATLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'ESPERANZA',
        'state_id' => 21
      ],
      [
        'name' => 'FRANCISCO Z. MENA',
        'state_id' => 21
      ],
      [
        'name' => 'GENERAL FELIPE ÁNGELES',
        'state_id' => 21
      ],
      [
        'name' => 'GUADALUPE',
        'state_id' => 21
      ],
      [
        'name' => 'GUADALUPE VICTORIA',
        'state_id' => 21
      ],
      [
        'name' => 'HERMENEGILDO GALEANA',
        'state_id' => 21
      ],
      [
        'name' => 'HUAQUECHULA',
        'state_id' => 21
      ],
      [
        'name' => 'HUATLATLAUCA',
        'state_id' => 21
      ],
      [
        'name' => 'HUAUCHINANGO',
        'state_id' => 21
      ],
      [
        'name' => 'HUEHUETLA',
        'state_id' => 21
      ],
      [
        'name' => 'HUEHUETLÁN EL CHICO',
        'state_id' => 21
      ],
      [
        'name' => 'HUEJOTZINGO',
        'state_id' => 21
      ],
      [
        'name' => 'HUEYAPAN',
        'state_id' => 21
      ],
      [
        'name' => 'HUEYTAMALCO',
        'state_id' => 21
      ],
      [
        'name' => 'HUEYTLALPAN',
        'state_id' => 21
      ],
      [
        'name' => 'HUITZILAN DE SERDÁN',
        'state_id' => 21
      ],
      [
        'name' => 'HUITZILTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'ATLEQUIZAYAN',
        'state_id' => 21
      ],
      [
        'name' => 'IXCAMILPA DE GUERRERO',
        'state_id' => 21
      ],
      [
        'name' => 'IXCAQUIXTLA',
        'state_id' => 21
      ],
      [
        'name' => 'IXTACAMAXTITLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'IXTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'IZÚCAR DE MATAMOROS',
        'state_id' => 21
      ],
      [
        'name' => 'JALPAN',
        'state_id' => 21
      ],
      [
        'name' => 'JOLALPAN',
        'state_id' => 21
      ],
      [
        'name' => 'JONOTLA',
        'state_id' => 21
      ],
      [
        'name' => 'JOPALA',
        'state_id' => 21
      ],
      [
        'name' => 'JUAN C. BONILLA',
        'state_id' => 21
      ],
      [
        'name' => 'JUAN GALINDO',
        'state_id' => 21
      ],
      [
        'name' => 'JUAN N. MÉNDEZ',
        'state_id' => 21
      ],
      [
        'name' => 'LAFRAGUA',
        'state_id' => 21
      ],
      [
        'name' => 'LIBRES',
        'state_id' => 21
      ],
      [
        'name' => 'LA MAGDALENA TLATLAUQUITEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'MAZAPILTEPEC DE JUÁREZ',
        'state_id' => 21
      ],
      [
        'name' => 'MIXTLA',
        'state_id' => 21
      ],
      [
        'name' => 'MOLCAXAC',
        'state_id' => 21
      ],
      [
        'name' => 'CAÑADA MORELOS',
        'state_id' => 21
      ],
      [
        'name' => 'NAUPAN',
        'state_id' => 21
      ],
      [
        'name' => 'NAUZONTLA',
        'state_id' => 21
      ],
      [
        'name' => 'NEALTICAN',
        'state_id' => 21
      ],
      [
        'name' => 'NICOLÁS BRAVO',
        'state_id' => 21
      ],
      [
        'name' => 'NOPALUCAN',
        'state_id' => 21
      ],
      [
        'name' => 'OCOTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'OCOYUCAN',
        'state_id' => 21
      ],
      [
        'name' => 'OLINTLA',
        'state_id' => 21
      ],
      [
        'name' => 'ORIENTAL',
        'state_id' => 21
      ],
      [
        'name' => 'PAHUATLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'PALMAR DE BRAVO',
        'state_id' => 21
      ],
      [
        'name' => 'PANTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'PETLALCINGO',
        'state_id' => 21
      ],
      [
        'name' => 'PIAXTLA',
        'state_id' => 21
      ],
      [
        'name' => 'PUEBLA',
        'state_id' => 21
      ],
      [
        'name' => 'QUECHOLAC',
        'state_id' => 21
      ],
      [
        'name' => 'QUIMIXTLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'RAFAEL LARA GRAJALES',
        'state_id' => 21
      ],
      [
        'name' => 'LOS REYES DE JUÁREZ',
        'state_id' => 21
      ],
      [
        'name' => 'SAN ANDRÉS CHOLULA',
        'state_id' => 21
      ],
      [
        'name' => 'SAN ANTONIO CAÑADA',
        'state_id' => 21
      ],
      [
        'name' => 'SAN DIEGO LA MESA TOCHIMILTZINGO',
        'state_id' => 21
      ],
      [
        'name' => 'SAN FELIPE TEOTLALCINGO',
        'state_id' => 21
      ],
      [
        'name' => 'SAN FELIPE TEPATLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'SAN GABRIEL CHILAC',
        'state_id' => 21
      ],
      [
        'name' => 'SAN GREGORIO ATZOMPA',
        'state_id' => 21
      ],
      [
        'name' => 'SAN JERÓNIMO TECUANIPAN',
        'state_id' => 21
      ],
      [
        'name' => 'SAN JERÓNIMO XAYACATLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'SAN JOSÉ CHIAPA',
        'state_id' => 21
      ],
      [
        'name' => 'SAN JOSÉ MIAHUATLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'SAN JUAN ATENCO',
        'state_id' => 21
      ],
      [
        'name' => 'SAN JUAN ATZOMPA',
        'state_id' => 21
      ],
      [
        'name' => 'SAN MARTÍN TEXMELUCAN',
        'state_id' => 21
      ],
      [
        'name' => 'SAN MARTÍN TOTOLTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'SAN MATÍAS TLALANCALECA',
        'state_id' => 21
      ],
      [
        'name' => 'SAN MIGUEL IXITLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'SAN MIGUEL XOXTLA',
        'state_id' => 21
      ],
      [
        'name' => 'SAN NICOLÁS BUENOS AIRES',
        'state_id' => 21
      ],
      [
        'name' => 'SAN NICOLÁS DE LOS RANCHOS',
        'state_id' => 21
      ],
      [
        'name' => 'SAN PABLO ANICANO',
        'state_id' => 21
      ],
      [
        'name' => 'SAN PEDRO CHOLULA',
        'state_id' => 21
      ],
      [
        'name' => 'SAN PEDRO YELOIXTLAHUACA',
        'state_id' => 21
      ],
      [
        'name' => 'SAN SALVADOR EL SECO',
        'state_id' => 21
      ],
      [
        'name' => 'SAN SALVADOR EL VERDE',
        'state_id' => 21
      ],
      [
        'name' => 'SAN SALVADOR HUIXCOLOTLA',
        'state_id' => 21
      ],
      [
        'name' => 'SAN SEBASTIÁN TLACOTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'SANTA CATARINA TLALTEMPAN',
        'state_id' => 21
      ],
      [
        'name' => 'SANTA INÉS AHUATEMPAN',
        'state_id' => 21
      ],
      [
        'name' => 'SANTA ISABEL CHOLULA',
        'state_id' => 21
      ],
      [
        'name' => 'SANTIAGO MIAHUATLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'HUEHUETLÁN EL GRANDE',
        'state_id' => 21
      ],
      [
        'name' => 'SANTO TOMÁS HUEYOTLIPAN',
        'state_id' => 21
      ],
      [
        'name' => 'SOLTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'TECALI DE HERRERA',
        'state_id' => 21
      ],
      [
        'name' => 'TECAMACHALCO',
        'state_id' => 21
      ],
      [
        'name' => 'TECOMATLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'TEHUACÁN',
        'state_id' => 21
      ],
      [
        'name' => 'TEHUITZINGO',
        'state_id' => 21
      ],
      [
        'name' => 'TENAMPULCO',
        'state_id' => 21
      ],
      [
        'name' => 'TEOPANTLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'TEOTLALCO',
        'state_id' => 21
      ],
      [
        'name' => 'TEPANCO DE LÓPEZ',
        'state_id' => 21
      ],
      [
        'name' => 'TEPANGO DE RODRÍGUEZ',
        'state_id' => 21
      ],
      [
        'name' => 'TEPATLAXCO DE HIDALGO',
        'state_id' => 21
      ],
      [
        'name' => 'TEPEACA',
        'state_id' => 21
      ],
      [
        'name' => 'TEPEMAXALCO',
        'state_id' => 21
      ],
      [
        'name' => 'TEPEOJUMA',
        'state_id' => 21
      ],
      [
        'name' => 'TEPETZINTLA',
        'state_id' => 21
      ],
      [
        'name' => 'TEPEXCO',
        'state_id' => 21
      ],
      [
        'name' => 'TEPEXI DE RODRÍGUEZ',
        'state_id' => 21
      ],
      [
        'name' => 'TEPEYAHUALCO',
        'state_id' => 21
      ],
      [
        'name' => 'TEPEYAHUALCO DE CUAUHTÉMOC',
        'state_id' => 21
      ],
      [
        'name' => 'TETELA DE OCAMPO',
        'state_id' => 21
      ],
      [
        'name' => 'TETELES DE ÁVILA CASTILLO',
        'state_id' => 21
      ],
      [
        'name' => 'TEZIUTLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'TIANGUISMANALCO',
        'state_id' => 21
      ],
      [
        'name' => 'TILAPA',
        'state_id' => 21
      ],
      [
        'name' => 'TLACOTEPEC DE BENITO JUÁREZ',
        'state_id' => 21
      ],
      [
        'name' => 'TLACUILOTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'TLACHICHUCA',
        'state_id' => 21
      ],
      [
        'name' => 'TLAHUAPAN',
        'state_id' => 21
      ],
      [
        'name' => 'TLALTENANGO',
        'state_id' => 21
      ],
      [
        'name' => 'TLANEPANTLA',
        'state_id' => 21
      ],
      [
        'name' => 'TLAOLA',
        'state_id' => 21
      ],
      [
        'name' => 'TLAPACOYA',
        'state_id' => 21
      ],
      [
        'name' => 'TLAPANALÁ',
        'state_id' => 21
      ],
      [
        'name' => 'TLATLAUQUITEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'TLAXCO',
        'state_id' => 21
      ],
      [
        'name' => 'TOCHIMILCO',
        'state_id' => 21
      ],
      [
        'name' => 'TOCHTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'TOTOLTEPEC DE GUERRERO',
        'state_id' => 21
      ],
      [
        'name' => 'TULCINGO',
        'state_id' => 21
      ],
      [
        'name' => 'TUZAMAPAN DE GALEANA',
        'state_id' => 21
      ],
      [
        'name' => 'TZICATLACOYAN',
        'state_id' => 21
      ],
      [
        'name' => 'VENUSTIANO CARRANZA',
        'state_id' => 21
      ],
      [
        'name' => 'VICENTE GUERRERO',
        'state_id' => 21
      ],
      [
        'name' => 'XAYACATLÁN DE BRAVO',
        'state_id' => 21
      ],
      [
        'name' => 'XICOTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'XICOTLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'XIUTETELCO',
        'state_id' => 21
      ],
      [
        'name' => 'XOCHIAPULCO',
        'state_id' => 21
      ],
      [
        'name' => 'XOCHILTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'XOCHITLÁN DE VICENTE SUÁREZ',
        'state_id' => 21
      ],
      [
        'name' => 'XOCHITLÁN TODOS SANTOS',
        'state_id' => 21
      ],
      [
        'name' => 'YAONÁHUAC',
        'state_id' => 21
      ],
      [
        'name' => 'YEHUALTEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'ZACAPALA',
        'state_id' => 21
      ],
      [
        'name' => 'ZACAPOAXTLA',
        'state_id' => 21
      ],
      [
        'name' => 'ZACATLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'ZAPOTITLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'ZAPOTITLÁN DE MÉNDEZ',
        'state_id' => 21
      ],
      [
        'name' => 'ZARAGOZA',
        'state_id' => 21
      ],
      [
        'name' => 'ZAUTLA',
        'state_id' => 21
      ],
      [
        'name' => 'ZIHUATEUTLA',
        'state_id' => 21
      ],
      [
        'name' => 'ZINACATEPEC',
        'state_id' => 21
      ],
      [
        'name' => 'ZONGOZOTLA',
        'state_id' => 21
      ],
      [
        'name' => 'ZOQUIAPAN',
        'state_id' => 21
      ],
      [
        'name' => 'ZOQUITLÁN',
        'state_id' => 21
      ],
      [
        'name' => 'AMEALCO DE BONFIL',
        'state_id' => 22
      ],
      [
        'name' => 'PINAL DE AMOLES',
        'state_id' => 22
      ],
      [
        'name' => 'ARROYO SECO',
        'state_id' => 22
      ],
      [
        'name' => 'CADEREYTA DE MONTES',
        'state_id' => 22
      ],
      [
        'name' => 'COLÓN',
        'state_id' => 22
      ],
      [
        'name' => 'CORREGIDORA',
        'state_id' => 22
      ],
      [
        'name' => 'EZEQUIEL MONTES',
        'state_id' => 22
      ],
      [
        'name' => 'HUIMILPAN',
        'state_id' => 22
      ],
      [
        'name' => 'JALPAN DE SERRA',
        'state_id' => 22
      ],
      [
        'name' => 'LANDA DE MATAMOROS',
        'state_id' => 22
      ],
      [
        'name' => 'EL MARQUÉS',
        'state_id' => 22
      ],
      [
        'name' => 'PEDRO ESCOBEDO',
        'state_id' => 22
      ],
      [
        'name' => 'PEÑAMILLER',
        'state_id' => 22
      ],
      [
        'name' => 'QUERÉTARO',
        'state_id' => 22
      ],
      [
        'name' => 'SAN JOAQUÍN',
        'state_id' => 22
      ],
      [
        'name' => 'SAN JUAN DEL RÍO',
        'state_id' => 22
      ],
      [
        'name' => 'TEQUISQUIAPAN',
        'state_id' => 22
      ],
      [
        'name' => 'TOLIMÁN',
        'state_id' => 22
      ],
      [
        'name' => 'COZUMEL',
        'state_id' => 23
      ],
      [
        'name' => 'FELIPE CARRILLO PUERTO',
        'state_id' => 23
      ],
      [
        'name' => 'ISLA MUJERES',
        'state_id' => 23
      ],
      [
        'name' => 'OTHÓN P. BLANCO',
        'state_id' => 23
      ],
      [
        'name' => 'BENITO JUÁREZ',
        'state_id' => 23
      ],
      [
        'name' => 'JOSÉ MARÍA MORELOS',
        'state_id' => 23
      ],
      [
        'name' => 'LÁZARO CÁRDENAS',
        'state_id' => 23
      ],
      [
        'name' => 'SOLIDARIDAD',
        'state_id' => 23
      ],
      [
        'name' => 'TULUM',
        'state_id' => 23
      ],
      [
        'name' => 'BACALAR',
        'state_id' => 23
      ],
      [
        'name' => 'PUERTO MORELOS',
        'state_id' => 23
      ],
      [
        'name' => 'AHUALULCO',
        'state_id' => 24
      ],
      [
        'name' => 'ALAQUINES',
        'state_id' => 24
      ],
      [
        'name' => 'AQUISMÓN',
        'state_id' => 24
      ],
      [
        'name' => 'ARMADILLO DE LOS INFANTE',
        'state_id' => 24
      ],
      [
        'name' => 'CÁRDENAS',
        'state_id' => 24
      ],
      [
        'name' => 'CATORCE',
        'state_id' => 24
      ],
      [
        'name' => 'CEDRAL',
        'state_id' => 24
      ],
      [
        'name' => 'CERRITOS',
        'state_id' => 24
      ],
      [
        'name' => 'CERRO DE SAN PEDRO',
        'state_id' => 24
      ],
      [
        'name' => 'CIUDAD DEL MAÍZ',
        'state_id' => 24
      ],
      [
        'name' => 'CIUDAD FERNÁNDEZ',
        'state_id' => 24
      ],
      [
        'name' => 'TANCANHUITZ',
        'state_id' => 24
      ],
      [
        'name' => 'CIUDAD VALLES',
        'state_id' => 24
      ],
      [
        'name' => 'COXCATLÁN',
        'state_id' => 24
      ],
      [
        'name' => 'CHARCAS',
        'state_id' => 24
      ],
      [
        'name' => 'EBANO',
        'state_id' => 24
      ],
      [
        'name' => 'GUADALCÁZAR',
        'state_id' => 24
      ],
      [
        'name' => 'HUEHUETLÁN',
        'state_id' => 24
      ],
      [
        'name' => 'LAGUNILLAS',
        'state_id' => 24
      ],
      [
        'name' => 'MATEHUALA',
        'state_id' => 24
      ],
      [
        'name' => 'MEXQUITIC DE CARMONA',
        'state_id' => 24
      ],
      [
        'name' => 'MOCTEZUMA',
        'state_id' => 24
      ],
      [
        'name' => 'RAYÓN',
        'state_id' => 24
      ],
      [
        'name' => 'RIOVERDE',
        'state_id' => 24
      ],
      [
        'name' => 'SALINAS',
        'state_id' => 24
      ],
      [
        'name' => 'SAN ANTONIO',
        'state_id' => 24
      ],
      [
        'name' => 'SAN CIRO DE ACOSTA',
        'state_id' => 24
      ],
      [
        'name' => 'SAN LUIS POTOSÍ',
        'state_id' => 24
      ],
      [
        'name' => 'SAN MARTÍN CHALCHICUAUTLA',
        'state_id' => 24
      ],
      [
        'name' => 'SAN NICOLÁS TOLENTINO',
        'state_id' => 24
      ],
      [
        'name' => 'SANTA CATARINA',
        'state_id' => 24
      ],
      [
        'name' => 'SANTA MARÍA DEL RÍO',
        'state_id' => 24
      ],
      [
        'name' => 'SANTO DOMINGO',
        'state_id' => 24
      ],
      [
        'name' => 'SAN VICENTE TANCUAYALAB',
        'state_id' => 24
      ],
      [
        'name' => 'SOLEDAD DE GRACIANO SÁNCHEZ',
        'state_id' => 24
      ],
      [
        'name' => 'TAMASOPO',
        'state_id' => 24
      ],
      [
        'name' => 'TAMAZUNCHALE',
        'state_id' => 24
      ],
      [
        'name' => 'TAMPACÁN',
        'state_id' => 24
      ],
      [
        'name' => 'TAMPAMOLÓN CORONA',
        'state_id' => 24
      ],
      [
        'name' => 'TAMUÍN',
        'state_id' => 24
      ],
      [
        'name' => 'TANLAJÁS',
        'state_id' => 24
      ],
      [
        'name' => 'TANQUIÁN DE ESCOBEDO',
        'state_id' => 24
      ],
      [
        'name' => 'TIERRA NUEVA',
        'state_id' => 24
      ],
      [
        'name' => 'VANEGAS',
        'state_id' => 24
      ],
      [
        'name' => 'VENADO',
        'state_id' => 24
      ],
      [
        'name' => 'VILLA DE ARRIAGA',
        'state_id' => 24
      ],
      [
        'name' => 'VILLA DE GUADALUPE',
        'state_id' => 24
      ],
      [
        'name' => 'VILLA DE LA PAZ',
        'state_id' => 24
      ],
      [
        'name' => 'VILLA DE RAMOS',
        'state_id' => 24
      ],
      [
        'name' => 'VILLA DE REYES',
        'state_id' => 24
      ],
      [
        'name' => 'VILLA HIDALGO',
        'state_id' => 24
      ],
      [
        'name' => 'VILLA JUÁREZ',
        'state_id' => 24
      ],
      [
        'name' => 'AXTLA DE TERRAZAS',
        'state_id' => 24
      ],
      [
        'name' => 'XILITLA',
        'state_id' => 24
      ],
      [
        'name' => 'ZARAGOZA',
        'state_id' => 24
      ],
      [
        'name' => 'VILLA DE ARISTA',
        'state_id' => 24
      ],
      [
        'name' => 'MATLAPA',
        'state_id' => 24
      ],
      [
        'name' => 'EL NARANJO',
        'state_id' => 24
      ],
      [
        'name' => 'AHOME',
        'state_id' => 25
      ],
      [
        'name' => 'ANGOSTURA',
        'state_id' => 25
      ],
      [
        'name' => 'BADIRAGUATO',
        'state_id' => 25
      ],
      [
        'name' => 'CONCORDIA',
        'state_id' => 25
      ],
      [
        'name' => 'COSALÁ',
        'state_id' => 25
      ],
      [
        'name' => 'CULIACÁN',
        'state_id' => 25
      ],
      [
        'name' => 'CHOIX',
        'state_id' => 25
      ],
      [
        'name' => 'ELOTA',
        'state_id' => 25
      ],
      [
        'name' => 'ESCUINAPA',
        'state_id' => 25
      ],
      [
        'name' => 'EL FUERTE',
        'state_id' => 25
      ],
      [
        'name' => 'GUASAVE',
        'state_id' => 25
      ],
      [
        'name' => 'MAZATLÁN',
        'state_id' => 25
      ],
      [
        'name' => 'MOCORITO',
        'state_id' => 25
      ],
      [
        'name' => 'ROSARIO',
        'state_id' => 25
      ],
      [
        'name' => 'SALVADOR ALVARADO',
        'state_id' => 25
      ],
      [
        'name' => 'SAN IGNACIO',
        'state_id' => 25
      ],
      [
        'name' => 'SINALOA',
        'state_id' => 25
      ],
      [
        'name' => 'NAVOLATO',
        'state_id' => 25
      ],
      [
        'name' => 'ACONCHI',
        'state_id' => 26
      ],
      [
        'name' => 'AGUA PRIETA',
        'state_id' => 26
      ],
      [
        'name' => 'ÁLAMOS',
        'state_id' => 26
      ],
      [
        'name' => 'ALTAR',
        'state_id' => 26
      ],
      [
        'name' => 'ARIVECHI',
        'state_id' => 26
      ],
      [
        'name' => 'ARIZPE',
        'state_id' => 26
      ],
      [
        'name' => 'ATIL',
        'state_id' => 26
      ],
      [
        'name' => 'BACADÉHUACHI',
        'state_id' => 26
      ],
      [
        'name' => 'BACANORA',
        'state_id' => 26
      ],
      [
        'name' => 'BACERAC',
        'state_id' => 26
      ],
      [
        'name' => 'BACOACHI',
        'state_id' => 26
      ],
      [
        'name' => 'BÁCUM',
        'state_id' => 26
      ],
      [
        'name' => 'BANÁMICHI',
        'state_id' => 26
      ],
      [
        'name' => 'BAVIÁCORA',
        'state_id' => 26
      ],
      [
        'name' => 'BAVISPE',
        'state_id' => 26
      ],
      [
        'name' => 'BENJAMÍN HILL',
        'state_id' => 26
      ],
      [
        'name' => 'CABORCA',
        'state_id' => 26
      ],
      [
        'name' => 'CAJEME',
        'state_id' => 26
      ],
      [
        'name' => 'CANANEA',
        'state_id' => 26
      ],
      [
        'name' => 'CARBÓ',
        'state_id' => 26
      ],
      [
        'name' => 'LA COLORADA',
        'state_id' => 26
      ],
      [
        'name' => 'CUCURPE',
        'state_id' => 26
      ],
      [
        'name' => 'CUMPAS',
        'state_id' => 26
      ],
      [
        'name' => 'DIVISADEROS',
        'state_id' => 26
      ],
      [
        'name' => 'EMPALME',
        'state_id' => 26
      ],
      [
        'name' => 'ETCHOJOA',
        'state_id' => 26
      ],
      [
        'name' => 'FRONTERAS',
        'state_id' => 26
      ],
      [
        'name' => 'GRANADOS',
        'state_id' => 26
      ],
      [
        'name' => 'GUAYMAS',
        'state_id' => 26
      ],
      [
        'name' => 'HERMOSILLO',
        'state_id' => 26
      ],
      [
        'name' => 'HUACHINERA',
        'state_id' => 26
      ],
      [
        'name' => 'HUÁSABAS',
        'state_id' => 26
      ],
      [
        'name' => 'HUATABAMPO',
        'state_id' => 26
      ],
      [
        'name' => 'HUÉPAC',
        'state_id' => 26
      ],
      [
        'name' => 'IMURIS',
        'state_id' => 26
      ],
      [
        'name' => 'MAGDALENA',
        'state_id' => 26
      ],
      [
        'name' => 'MAZATÁN',
        'state_id' => 26
      ],
      [
        'name' => 'MOCTEZUMA',
        'state_id' => 26
      ],
      [
        'name' => 'NACO',
        'state_id' => 26
      ],
      [
        'name' => 'NÁCORI CHICO',
        'state_id' => 26
      ],
      [
        'name' => 'NACOZARI DE GARCÍA',
        'state_id' => 26
      ],
      [
        'name' => 'NAVOJOA',
        'state_id' => 26
      ],
      [
        'name' => 'NOGALES',
        'state_id' => 26
      ],
      [
        'name' => 'ÓNAVAS',
        'state_id' => 26
      ],
      [
        'name' => 'OPODEPE',
        'state_id' => 26
      ],
      [
        'name' => 'OQUITOA',
        'state_id' => 26
      ],
      [
        'name' => 'PITIQUITO',
        'state_id' => 26
      ],
      [
        'name' => 'PUERTO PEÑASCO',
        'state_id' => 26
      ],
      [
        'name' => 'QUIRIEGO',
        'state_id' => 26
      ],
      [
        'name' => 'RAYÓN',
        'state_id' => 26
      ],
      [
        'name' => 'ROSARIO',
        'state_id' => 26
      ],
      [
        'name' => 'SAHUARIPA',
        'state_id' => 26
      ],
      [
        'name' => 'SAN FELIPE DE JESÚS',
        'state_id' => 26
      ],
      [
        'name' => 'SAN JAVIER',
        'state_id' => 26
      ],
      [
        'name' => 'SAN LUIS RÍO COLORADO',
        'state_id' => 26
      ],
      [
        'name' => 'SAN MIGUEL DE HORCASITAS',
        'state_id' => 26
      ],
      [
        'name' => 'SAN PEDRO DE LA CUEVA',
        'state_id' => 26
      ],
      [
        'name' => 'SANTA ANA',
        'state_id' => 26
      ],
      [
        'name' => 'SANTA CRUZ',
        'state_id' => 26
      ],
      [
        'name' => 'SÁRIC',
        'state_id' => 26
      ],
      [
        'name' => 'SOYOPA',
        'state_id' => 26
      ],
      [
        'name' => 'SUAQUI GRANDE',
        'state_id' => 26
      ],
      [
        'name' => 'TEPACHE',
        'state_id' => 26
      ],
      [
        'name' => 'TRINCHERAS',
        'state_id' => 26
      ],
      [
        'name' => 'TUBUTAMA',
        'state_id' => 26
      ],
      [
        'name' => 'URES',
        'state_id' => 26
      ],
      [
        'name' => 'VILLA HIDALGO',
        'state_id' => 26
      ],
      [
        'name' => 'VILLA PESQUEIRA',
        'state_id' => 26
      ],
      [
        'name' => 'YÉCORA',
        'state_id' => 26
      ],
      [
        'name' => 'GENERAL PLUTARCO ELÍAS CALLES',
        'state_id' => 26
      ],
      [
        'name' => 'BENITO JUÁREZ',
        'state_id' => 26
      ],
      [
        'name' => 'SAN IGNACIO RÍO MUERTO',
        'state_id' => 26
      ],
      [
        'name' => 'BALANCÁN',
        'state_id' => 27
      ],
      [
        'name' => 'CÁRDENAS',
        'state_id' => 27
      ],
      [
        'name' => 'CENTLA',
        'state_id' => 27
      ],
      [
        'name' => 'CENTRO',
        'state_id' => 27
      ],
      [
        'name' => 'COMALCALCO',
        'state_id' => 27
      ],
      [
        'name' => 'CUNDUACÁN',
        'state_id' => 27
      ],
      [
        'name' => 'EMILIANO ZAPATA',
        'state_id' => 27
      ],
      [
        'name' => 'HUIMANGUILLO',
        'state_id' => 27
      ],
      [
        'name' => 'JALAPA',
        'state_id' => 27
      ],
      [
        'name' => 'JALPA DE MÉNDEZ',
        'state_id' => 27
      ],
      [
        'name' => 'JONUTA',
        'state_id' => 27
      ],
      [
        'name' => 'MACUSPANA',
        'state_id' => 27
      ],
      [
        'name' => 'NACAJUCA',
        'state_id' => 27
      ],
      [
        'name' => 'PARAÍSO',
        'state_id' => 27
      ],
      [
        'name' => 'TACOTALPA',
        'state_id' => 27
      ],
      [
        'name' => 'TEAPA',
        'state_id' => 27
      ],
      [
        'name' => 'TENOSIQUE',
        'state_id' => 27
      ],
      [
        'name' => 'ABASOLO',
        'state_id' => 28
      ],
      [
        'name' => 'ALDAMA',
        'state_id' => 28
      ],
      [
        'name' => 'ALTAMIRA',
        'state_id' => 28
      ],
      [
        'name' => 'ANTIGUO MORELOS',
        'state_id' => 28
      ],
      [
        'name' => 'BURGOS',
        'state_id' => 28
      ],
      [
        'name' => 'BUSTAMANTE',
        'state_id' => 28
      ],
      [
        'name' => 'CAMARGO',
        'state_id' => 28
      ],
      [
        'name' => 'CASAS',
        'state_id' => 28
      ],
      [
        'name' => 'CIUDAD MADERO',
        'state_id' => 28
      ],
      [
        'name' => 'CRUILLAS',
        'state_id' => 28
      ],
      [
        'name' => 'GÓMEZ FARÍAS',
        'state_id' => 28
      ],
      [
        'name' => 'GONZÁLEZ',
        'state_id' => 28
      ],
      [
        'name' => 'GÜÉMEZ',
        'state_id' => 28
      ],
      [
        'name' => 'GUERRERO',
        'state_id' => 28
      ],
      [
        'name' => 'GUSTAVO DÍAZ ORDAZ',
        'state_id' => 28
      ],
      [
        'name' => 'HIDALGO',
        'state_id' => 28
      ],
      [
        'name' => 'JAUMAVE',
        'state_id' => 28
      ],
      [
        'name' => 'JIMÉNEZ',
        'state_id' => 28
      ],
      [
        'name' => 'LLERA',
        'state_id' => 28
      ],
      [
        'name' => 'MAINERO',
        'state_id' => 28
      ],
      [
        'name' => 'EL MANTE',
        'state_id' => 28
      ],
      [
        'name' => 'MATAMOROS',
        'state_id' => 28
      ],
      [
        'name' => 'MÉNDEZ',
        'state_id' => 28
      ],
      [
        'name' => 'MIER',
        'state_id' => 28
      ],
      [
        'name' => 'MIGUEL ALEMÁN',
        'state_id' => 28
      ],
      [
        'name' => 'MIQUIHUANA',
        'state_id' => 28
      ],
      [
        'name' => 'NUEVO LAREDO',
        'state_id' => 28
      ],
      [
        'name' => 'NUEVO MORELOS',
        'state_id' => 28
      ],
      [
        'name' => 'OCAMPO',
        'state_id' => 28
      ],
      [
        'name' => 'PADILLA',
        'state_id' => 28
      ],
      [
        'name' => 'PALMILLAS',
        'state_id' => 28
      ],
      [
        'name' => 'REYNOSA',
        'state_id' => 28
      ],
      [
        'name' => 'RÍO BRAVO',
        'state_id' => 28
      ],
      [
        'name' => 'SAN CARLOS',
        'state_id' => 28
      ],
      [
        'name' => 'SAN FERNANDO',
        'state_id' => 28
      ],
      [
        'name' => 'SAN NICOLÁS',
        'state_id' => 28
      ],
      [
        'name' => 'SOTO LA MARINA',
        'state_id' => 28
      ],
      [
        'name' => 'TAMPICO',
        'state_id' => 28
      ],
      [
        'name' => 'TULA',
        'state_id' => 28
      ],
      [
        'name' => 'VALLE HERMOSO',
        'state_id' => 28
      ],
      [
        'name' => 'VICTORIA',
        'state_id' => 28
      ],
      [
        'name' => 'VILLAGRÁN',
        'state_id' => 28
      ],
      [
        'name' => 'XICOTÉNCATL',
        'state_id' => 28
      ],
      [
        'name' => 'AMAXAC DE GUERRERO',
        'state_id' => 29
      ],
      [
        'name' => 'APETATITLÁN DE ANTONIO CARVAJAL',
        'state_id' => 29
      ],
      [
        'name' => 'ATLANGATEPEC',
        'state_id' => 29
      ],
      [
        'name' => 'ATLTZAYANCA',
        'state_id' => 29
      ],
      [
        'name' => 'APIZACO',
        'state_id' => 29
      ],
      [
        'name' => 'CALPULALPAN',
        'state_id' => 29
      ],
      [
        'name' => 'EL CARMEN TEQUEXQUITLA',
        'state_id' => 29
      ],
      [
        'name' => 'CUAPIAXTLA',
        'state_id' => 29
      ],
      [
        'name' => 'CUAXOMULCO',
        'state_id' => 29
      ],
      [
        'name' => 'CHIAUTEMPAN',
        'state_id' => 29
      ],
      [
        'name' => 'MUÑOZ DE DOMINGO ARENAS',
        'state_id' => 29
      ],
      [
        'name' => 'ESPAÑITA',
        'state_id' => 29
      ],
      [
        'name' => 'HUAMANTLA',
        'state_id' => 29
      ],
      [
        'name' => 'HUEYOTLIPAN',
        'state_id' => 29
      ],
      [
        'name' => 'IXTACUIXTLA DE MARIANO MATAMOROS',
        'state_id' => 29
      ],
      [
        'name' => 'IXTENCO',
        'state_id' => 29
      ],
      [
        'name' => 'MAZATECOCHCO DE JOSÉ MARÍA MORELOS',
        'state_id' => 29
      ],
      [
        'name' => 'CONTLA DE JUAN CUAMATZI',
        'state_id' => 29
      ],
      [
        'name' => 'TEPETITLA DE LARDIZÁBAL',
        'state_id' => 29
      ],
      [
        'name' => 'SANCTÓRUM DE LÁZARO CÁRDENAS',
        'state_id' => 29
      ],
      [
        'name' => 'NANACAMILPA DE MARIANO ARISTA',
        'state_id' => 29
      ],
      [
        'name' => 'ACUAMANALA DE MIGUEL HIDALGO',
        'state_id' => 29
      ],
      [
        'name' => 'NATÍVITAS',
        'state_id' => 29
      ],
      [
        'name' => 'PANOTLA',
        'state_id' => 29
      ],
      [
        'name' => 'SAN PABLO DEL MONTE',
        'state_id' => 29
      ],
      [
        'name' => 'SANTA CRUZ TLAXCALA',
        'state_id' => 29
      ],
      [
        'name' => 'TENANCINGO',
        'state_id' => 29
      ],
      [
        'name' => 'TEOLOCHOLCO',
        'state_id' => 29
      ],
      [
        'name' => 'TEPEYANCO',
        'state_id' => 29
      ],
      [
        'name' => 'TERRENATE',
        'state_id' => 29
      ],
      [
        'name' => 'TETLA DE LA SOLIDARIDAD',
        'state_id' => 29
      ],
      [
        'name' => 'TETLATLAHUCA',
        'state_id' => 29
      ],
      [
        'name' => 'TLAXCALA',
        'state_id' => 29
      ],
      [
        'name' => 'TLAXCO',
        'state_id' => 29
      ],
      [
        'name' => 'TOCATLÁN',
        'state_id' => 29
      ],
      [
        'name' => 'TOTOLAC',
        'state_id' => 29
      ],
      [
        'name' => 'ZILTLALTÉPEC DE TRINIDAD SÁNCHEZ SANTOS',
        'state_id' => 29
      ],
      [
        'name' => 'TZOMPANTEPEC',
        'state_id' => 29
      ],
      [
        'name' => 'XALOZTOC',
        'state_id' => 29
      ],
      [
        'name' => 'XALTOCAN',
        'state_id' => 29
      ],
      [
        'name' => 'PAPALOTLA DE XICOHTÉNCATL',
        'state_id' => 29
      ],
      [
        'name' => 'XICOHTZINCO',
        'state_id' => 29
      ],
      [
        'name' => 'YAUHQUEMEHCAN',
        'state_id' => 29
      ],
      [
        'name' => 'ZACATELCO',
        'state_id' => 29
      ],
      [
        'name' => 'BENITO JUÁREZ',
        'state_id' => 29
      ],
      [
        'name' => 'EMILIANO ZAPATA',
        'state_id' => 29
      ],
      [
        'name' => 'LÁZARO CÁRDENAS',
        'state_id' => 29
      ],
      [
        'name' => 'LA MAGDALENA TLALTELULCO',
        'state_id' => 29
      ],
      [
        'name' => 'SAN DAMIÁN TEXÓLOC',
        'state_id' => 29
      ],
      [
        'name' => 'SAN FRANCISCO TETLANOHCAN',
        'state_id' => 29
      ],
      [
        'name' => 'SAN JERÓNIMO ZACUALPAN',
        'state_id' => 29
      ],
      [
        'name' => 'SAN JOSÉ TEACALCO',
        'state_id' => 29
      ],
      [
        'name' => 'SAN JUAN HUACTZINCO',
        'state_id' => 29
      ],
      [
        'name' => 'SAN LORENZO AXOCOMANITLA',
        'state_id' => 29
      ],
      [
        'name' => 'SAN LUCAS TECOPILCO',
        'state_id' => 29
      ],
      [
        'name' => 'SANTA ANA NOPALUCAN',
        'state_id' => 29
      ],
      [
        'name' => 'SANTA APOLONIA TEACALCO',
        'state_id' => 29
      ],
      [
        'name' => 'SANTA CATARINA AYOMETLA',
        'state_id' => 29
      ],
      [
        'name' => 'SANTA CRUZ QUILEHTLA',
        'state_id' => 29
      ],
      [
        'name' => 'SANTA ISABEL XILOXOXTLA',
        'state_id' => 29
      ],
      [
        'name' => 'ACAJETE',
        'state_id' => 30
      ],
      [
        'name' => 'ACATLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'ACAYUCAN',
        'state_id' => 30
      ],
      [
        'name' => 'ACTOPAN',
        'state_id' => 30
      ],
      [
        'name' => 'ACULA',
        'state_id' => 30
      ],
      [
        'name' => 'ACULTZINGO',
        'state_id' => 30
      ],
      [
        'name' => 'CAMARÓN DE TEJEDA',
        'state_id' => 30
      ],
      [
        'name' => 'ALPATLÁHUAC',
        'state_id' => 30
      ],
      [
        'name' => 'ALTO LUCERO DE GUTIÉRREZ BARRIOS',
        'state_id' => 30
      ],
      [
        'name' => 'ALTOTONGA',
        'state_id' => 30
      ],
      [
        'name' => 'ALVARADO',
        'state_id' => 30
      ],
      [
        'name' => 'AMATITLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'NARANJOS AMATLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'AMATLÁN DE LOS REYES',
        'state_id' => 30
      ],
      [
        'name' => 'ANGEL R. CABADA',
        'state_id' => 30
      ],
      [
        'name' => 'LA ANTIGUA',
        'state_id' => 30
      ],
      [
        'name' => 'APAZAPAN',
        'state_id' => 30
      ],
      [
        'name' => 'AQUILA',
        'state_id' => 30
      ],
      [
        'name' => 'ASTACINGA',
        'state_id' => 30
      ],
      [
        'name' => 'ATLAHUILCO',
        'state_id' => 30
      ],
      [
        'name' => 'ATOYAC',
        'state_id' => 30
      ],
      [
        'name' => 'ATZACAN',
        'state_id' => 30
      ],
      [
        'name' => 'ATZALAN',
        'state_id' => 30
      ],
      [
        'name' => 'TLALTETELA',
        'state_id' => 30
      ],
      [
        'name' => 'AYAHUALULCO',
        'state_id' => 30
      ],
      [
        'name' => 'BANDERILLA',
        'state_id' => 30
      ],
      [
        'name' => 'BENITO JUÁREZ',
        'state_id' => 30
      ],
      [
        'name' => 'BOCA DEL RÍO',
        'state_id' => 30
      ],
      [
        'name' => 'CALCAHUALCO',
        'state_id' => 30
      ],
      [
        'name' => 'CAMERINO Z. MENDOZA',
        'state_id' => 30
      ],
      [
        'name' => 'CARRILLO PUERTO',
        'state_id' => 30
      ],
      [
        'name' => 'CATEMACO',
        'state_id' => 30
      ],
      [
        'name' => 'CAZONES DE HERRERA',
        'state_id' => 30
      ],
      [
        'name' => 'CERRO AZUL',
        'state_id' => 30
      ],
      [
        'name' => 'CITLALTÉPETL',
        'state_id' => 30
      ],
      [
        'name' => 'COACOATZINTLA',
        'state_id' => 30
      ],
      [
        'name' => 'COAHUITLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'COATEPEC',
        'state_id' => 30
      ],
      [
        'name' => 'COATZACOALCOS',
        'state_id' => 30
      ],
      [
        'name' => 'COATZINTLA',
        'state_id' => 30
      ],
      [
        'name' => 'COETZALA',
        'state_id' => 30
      ],
      [
        'name' => 'COLIPA',
        'state_id' => 30
      ],
      [
        'name' => 'COMAPA',
        'state_id' => 30
      ],
      [
        'name' => 'CÓRDOBA',
        'state_id' => 30
      ],
      [
        'name' => 'COSAMALOAPAN DE CARPIO',
        'state_id' => 30
      ],
      [
        'name' => 'COSAUTLÁN DE CARVAJAL',
        'state_id' => 30
      ],
      [
        'name' => 'COSCOMATEPEC',
        'state_id' => 30
      ],
      [
        'name' => 'COSOLEACAQUE',
        'state_id' => 30
      ],
      [
        'name' => 'COTAXTLA',
        'state_id' => 30
      ],
      [
        'name' => 'COXQUIHUI',
        'state_id' => 30
      ],
      [
        'name' => 'COYUTLA',
        'state_id' => 30
      ],
      [
        'name' => 'CUICHAPA',
        'state_id' => 30
      ],
      [
        'name' => 'CUITLÁHUAC',
        'state_id' => 30
      ],
      [
        'name' => 'CHACALTIANGUIS',
        'state_id' => 30
      ],
      [
        'name' => 'CHALMA',
        'state_id' => 30
      ],
      [
        'name' => 'CHICOnameL',
        'state_id' => 30
      ],
      [
        'name' => 'CHICONQUIACO',
        'state_id' => 30
      ],
      [
        'name' => 'CHICONTEPEC',
        'state_id' => 30
      ],
      [
        'name' => 'CHInameCA',
        'state_id' => 30
      ],
      [
        'name' => 'CHINAMPA DE GOROSTIZA',
        'state_id' => 30
      ],
      [
        'name' => 'LAS CHOAPAS',
        'state_id' => 30
      ],
      [
        'name' => 'CHOCAMÁN',
        'state_id' => 30
      ],
      [
        'name' => 'CHONTLA',
        'state_id' => 30
      ],
      [
        'name' => 'CHUMATLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'EMILIANO ZAPATA',
        'state_id' => 30
      ],
      [
        'name' => 'ESPINAL',
        'state_id' => 30
      ],
      [
        'name' => 'FILOMENO MATA',
        'state_id' => 30
      ],
      [
        'name' => 'FORTÍN',
        'state_id' => 30
      ],
      [
        'name' => 'GUTIÉRREZ ZAMORA',
        'state_id' => 30
      ],
      [
        'name' => 'HIDALGOTITLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'HUATUSCO',
        'state_id' => 30
      ],
      [
        'name' => 'HUAYACOCOTLA',
        'state_id' => 30
      ],
      [
        'name' => 'HUEYAPAN DE OCAMPO',
        'state_id' => 30
      ],
      [
        'name' => 'HUILOAPAN DE CUAUHTÉMOC',
        'state_id' => 30
      ],
      [
        'name' => 'IGNACIO DE LA LLAVE',
        'state_id' => 30
      ],
      [
        'name' => 'ILAMATLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'ISLA',
        'state_id' => 30
      ],
      [
        'name' => 'IXCATEPEC',
        'state_id' => 30
      ],
      [
        'name' => 'IXHUACÁN DE LOS REYES',
        'state_id' => 30
      ],
      [
        'name' => 'IXHUATLÁN DEL CAFÉ',
        'state_id' => 30
      ],
      [
        'name' => 'IXHUATLANCILLO',
        'state_id' => 30
      ],
      [
        'name' => 'IXHUATLÁN DEL SURESTE',
        'state_id' => 30
      ],
      [
        'name' => 'IXHUATLÁN DE MADERO',
        'state_id' => 30
      ],
      [
        'name' => 'IXMATLAHUACAN',
        'state_id' => 30
      ],
      [
        'name' => 'IXTACZOQUITLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'JALACINGO',
        'state_id' => 30
      ],
      [
        'name' => 'XALAPA',
        'state_id' => 30
      ],
      [
        'name' => 'JALCOMULCO',
        'state_id' => 30
      ],
      [
        'name' => 'JÁLTIPAN',
        'state_id' => 30
      ],
      [
        'name' => 'JAMAPA',
        'state_id' => 30
      ],
      [
        'name' => 'JESÚS CARRANZA',
        'state_id' => 30
      ],
      [
        'name' => 'XICO',
        'state_id' => 30
      ],
      [
        'name' => 'JILOTEPEC',
        'state_id' => 30
      ],
      [
        'name' => 'JUAN RODRÍGUEZ CLARA',
        'state_id' => 30
      ],
      [
        'name' => 'JUCHIQUE DE FERRER',
        'state_id' => 30
      ],
      [
        'name' => 'LANDERO Y COSS',
        'state_id' => 30
      ],
      [
        'name' => 'LERDO DE TEJADA',
        'state_id' => 30
      ],
      [
        'name' => 'MAGDALENA',
        'state_id' => 30
      ],
      [
        'name' => 'MALTRATA',
        'state_id' => 30
      ],
      [
        'name' => 'MANLIO FABIO ALTAMIRANO',
        'state_id' => 30
      ],
      [
        'name' => 'MARIANO ESCOBEDO',
        'state_id' => 30
      ],
      [
        'name' => 'MARTÍNEZ DE LA TORRE',
        'state_id' => 30
      ],
      [
        'name' => 'MECATLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'MECAYAPAN',
        'state_id' => 30
      ],
      [
        'name' => 'MEDELLÍN DE BRAVO',
        'state_id' => 30
      ],
      [
        'name' => 'MIAHUATLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'LAS MINAS',
        'state_id' => 30
      ],
      [
        'name' => 'MINATITLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'MISANTLA',
        'state_id' => 30
      ],
      [
        'name' => 'MIXTLA DE ALTAMIRANO',
        'state_id' => 30
      ],
      [
        'name' => 'MOLOACÁN',
        'state_id' => 30
      ],
      [
        'name' => 'NAOLINCO',
        'state_id' => 30
      ],
      [
        'name' => 'NARANJAL',
        'state_id' => 30
      ],
      [
        'name' => 'NAUTLA',
        'state_id' => 30
      ],
      [
        'name' => 'NOGALES',
        'state_id' => 30
      ],
      [
        'name' => 'OLUTA',
        'state_id' => 30
      ],
      [
        'name' => 'OMEALCA',
        'state_id' => 30
      ],
      [
        'name' => 'ORIZABA',
        'state_id' => 30
      ],
      [
        'name' => 'OTATITLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'OTEAPAN',
        'state_id' => 30
      ],
      [
        'name' => 'OZULUAMA DE MASCAREÑAS',
        'state_id' => 30
      ],
      [
        'name' => 'PAJAPAN',
        'state_id' => 30
      ],
      [
        'name' => 'PÁNUCO',
        'state_id' => 30
      ],
      [
        'name' => 'PAPANTLA',
        'state_id' => 30
      ],
      [
        'name' => 'PASO DEL MACHO',
        'state_id' => 30
      ],
      [
        'name' => 'PASO DE OVEJAS',
        'state_id' => 30
      ],
      [
        'name' => 'LA PERLA',
        'state_id' => 30
      ],
      [
        'name' => 'PEROTE',
        'state_id' => 30
      ],
      [
        'name' => 'PLATÓN SÁNCHEZ',
        'state_id' => 30
      ],
      [
        'name' => 'PLAYA VICENTE',
        'state_id' => 30
      ],
      [
        'name' => 'POZA RICA DE HIDALGO',
        'state_id' => 30
      ],
      [
        'name' => 'LAS VIGAS DE RAMÍREZ',
        'state_id' => 30
      ],
      [
        'name' => 'PUEBLO VIEJO',
        'state_id' => 30
      ],
      [
        'name' => 'PUENTE NACIONAL',
        'state_id' => 30
      ],
      [
        'name' => 'RAFAEL DELGADO',
        'state_id' => 30
      ],
      [
        'name' => 'RAFAEL LUCIO',
        'state_id' => 30
      ],
      [
        'name' => 'LOS REYES',
        'state_id' => 30
      ],
      [
        'name' => 'RÍO BLANCO',
        'state_id' => 30
      ],
      [
        'name' => 'SALTABARRANCA',
        'state_id' => 30
      ],
      [
        'name' => 'SAN ANDRÉS TENEJAPAN',
        'state_id' => 30
      ],
      [
        'name' => 'SAN ANDRÉS TUXTLA',
        'state_id' => 30
      ],
      [
        'name' => 'SAN JUAN EVANGELISTA',
        'state_id' => 30
      ],
      [
        'name' => 'SANTIAGO TUXTLA',
        'state_id' => 30
      ],
      [
        'name' => 'SAYULA DE ALEMÁN',
        'state_id' => 30
      ],
      [
        'name' => 'SOCONUSCO',
        'state_id' => 30
      ],
      [
        'name' => 'SOCHIAPA',
        'state_id' => 30
      ],
      [
        'name' => 'SOLEDAD ATZOMPA',
        'state_id' => 30
      ],
      [
        'name' => 'SOLEDAD DE DOBLADO',
        'state_id' => 30
      ],
      [
        'name' => 'SOTEAPAN',
        'state_id' => 30
      ],
      [
        'name' => 'TAMALÍN',
        'state_id' => 30
      ],
      [
        'name' => 'TAMIAHUA',
        'state_id' => 30
      ],
      [
        'name' => 'TAMPICO ALTO',
        'state_id' => 30
      ],
      [
        'name' => 'TANCOCO',
        'state_id' => 30
      ],
      [
        'name' => 'TANTIMA',
        'state_id' => 30
      ],
      [
        'name' => 'TANTOYUCA',
        'state_id' => 30
      ],
      [
        'name' => 'TATATILA',
        'state_id' => 30
      ],
      [
        'name' => 'CASTILLO DE TEAYO',
        'state_id' => 30
      ],
      [
        'name' => 'TECOLUTLA',
        'state_id' => 30
      ],
      [
        'name' => 'TEHUIPANGO',
        'state_id' => 30
      ],
      [
        'name' => 'ÁLAMO TEMAPACHE',
        'state_id' => 30
      ],
      [
        'name' => 'TEMPOAL',
        'state_id' => 30
      ],
      [
        'name' => 'TENAMPA',
        'state_id' => 30
      ],
      [
        'name' => 'TENOCHTITLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'TEOCELO',
        'state_id' => 30
      ],
      [
        'name' => 'TEPATLAXCO',
        'state_id' => 30
      ],
      [
        'name' => 'TEPETLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'TEPETZINTLA',
        'state_id' => 30
      ],
      [
        'name' => 'TEQUILA',
        'state_id' => 30
      ],
      [
        'name' => 'JOSÉ AZUETA',
        'state_id' => 30
      ],
      [
        'name' => 'TEXCATEPEC',
        'state_id' => 30
      ],
      [
        'name' => 'TEXHUACÁN',
        'state_id' => 30
      ],
      [
        'name' => 'TEXISTEPEC',
        'state_id' => 30
      ],
      [
        'name' => 'TEZONAPA',
        'state_id' => 30
      ],
      [
        'name' => 'TIERRA BLANCA',
        'state_id' => 30
      ],
      [
        'name' => 'TIHUATLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'TLACOJALPAN',
        'state_id' => 30
      ],
      [
        'name' => 'TLACOLULAN',
        'state_id' => 30
      ],
      [
        'name' => 'TLACOTALPAN',
        'state_id' => 30
      ],
      [
        'name' => 'TLACOTEPEC DE MEJÍA',
        'state_id' => 30
      ],
      [
        'name' => 'TLACHICHILCO',
        'state_id' => 30
      ],
      [
        'name' => 'TLALIXCOYAN',
        'state_id' => 30
      ],
      [
        'name' => 'TLALNELHUAYOCAN',
        'state_id' => 30
      ],
      [
        'name' => 'TLAPACOYAN',
        'state_id' => 30
      ],
      [
        'name' => 'TLAQUILPA',
        'state_id' => 30
      ],
      [
        'name' => 'TLILAPAN',
        'state_id' => 30
      ],
      [
        'name' => 'TOMATLÁN',
        'state_id' => 30
      ],
      [
        'name' => 'TONAYÁN',
        'state_id' => 30
      ],
      [
        'name' => 'TOTUTLA',
        'state_id' => 30
      ],
      [
        'name' => 'TUXPAN',
        'state_id' => 30
      ],
      [
        'name' => 'TUXTILLA',
        'state_id' => 30
      ],
      [
        'name' => 'URSULO GALVÁN',
        'state_id' => 30
      ],
      [
        'name' => 'VEGA DE ALATORRE',
        'state_id' => 30
      ],
      [
        'name' => 'VERACRUZ',
        'state_id' => 30
      ],
      [
        'name' => 'VILLA ALDAMA',
        'state_id' => 30
      ],
      [
        'name' => 'XOXOCOTLA',
        'state_id' => 30
      ],
      [
        'name' => 'YANGA',
        'state_id' => 30
      ],
      [
        'name' => 'YECUATLA',
        'state_id' => 30
      ],
      [
        'name' => 'ZACUALPAN',
        'state_id' => 30
      ],
      [
        'name' => 'ZARAGOZA',
        'state_id' => 30
      ],
      [
        'name' => 'ZENTLA',
        'state_id' => 30
      ],
      [
        'name' => 'ZONGOLICA',
        'state_id' => 30
      ],
      [
        'name' => 'ZONTECOMATLÁN DE LÓPEZ Y FUENTES',
        'state_id' => 30
      ],
      [
        'name' => 'ZOZOCOLCO DE HIDALGO',
        'state_id' => 30
      ],
      [
        'name' => 'AGUA DULCE',
        'state_id' => 30
      ],
      [
        'name' => 'EL HIGO',
        'state_id' => 30
      ],
      [
        'name' => 'NANCHITAL DE LÁZARO CÁRDENAS DEL RÍO',
        'state_id' => 30
      ],
      [
        'name' => 'TRES VALLES',
        'state_id' => 30
      ],
      [
        'name' => 'CARLOS A. CARRILLO',
        'state_id' => 30
      ],
      [
        'name' => 'TATAHUICAPAN DE JUÁREZ',
        'state_id' => 30
      ],
      [
        'name' => 'UXPANAPA',
        'state_id' => 30
      ],
      [
        'name' => 'SAN RAFAEL',
        'state_id' => 30
      ],
      [
        'name' => 'SANTIAGO SOCHIAPAN',
        'state_id' => 30
      ],
      [
        'name' => 'ABALÁ',
        'state_id' => 31
      ],
      [
        'name' => 'ACANCEH',
        'state_id' => 31
      ],
      [
        'name' => 'AKIL',
        'state_id' => 31
      ],
      [
        'name' => 'BACA',
        'state_id' => 31
      ],
      [
        'name' => 'BOKOBÁ',
        'state_id' => 31
      ],
      [
        'name' => 'BUCTZOTZ',
        'state_id' => 31
      ],
      [
        'name' => 'CACALCHÉN',
        'state_id' => 31
      ],
      [
        'name' => 'CALOTMUL',
        'state_id' => 31
      ],
      [
        'name' => 'CANSAHCAB',
        'state_id' => 31
      ],
      [
        'name' => 'CANTAMAYEC',
        'state_id' => 31
      ],
      [
        'name' => 'CELESTÚN',
        'state_id' => 31
      ],
      [
        'name' => 'CENOTILLO',
        'state_id' => 31
      ],
      [
        'name' => 'CONKAL',
        'state_id' => 31
      ],
      [
        'name' => 'CUNCUNUL',
        'state_id' => 31
      ],
      [
        'name' => 'CUZAMÁ',
        'state_id' => 31
      ],
      [
        'name' => 'CHACSINKÍN',
        'state_id' => 31
      ],
      [
        'name' => 'CHANKOM',
        'state_id' => 31
      ],
      [
        'name' => 'CHAPAB',
        'state_id' => 31
      ],
      [
        'name' => 'CHEMAX',
        'state_id' => 31
      ],
      [
        'name' => 'CHICXULUB PUEBLO',
        'state_id' => 31
      ],
      [
        'name' => 'CHICHIMILÁ',
        'state_id' => 31
      ],
      [
        'name' => 'CHIKINDZONOT',
        'state_id' => 31
      ],
      [
        'name' => 'CHOCHOLÁ',
        'state_id' => 31
      ],
      [
        'name' => 'CHUMAYEL',
        'state_id' => 31
      ],
      [
        'name' => 'DZÁN',
        'state_id' => 31
      ],
      [
        'name' => 'DZEMUL',
        'state_id' => 31
      ],
      [
        'name' => 'DZIDZANTÚN',
        'state_id' => 31
      ],
      [
        'name' => 'DZILAM DE BRAVO',
        'state_id' => 31
      ],
      [
        'name' => 'DZILAM GONZÁLEZ',
        'state_id' => 31
      ],
      [
        'name' => 'DZITÁS',
        'state_id' => 31
      ],
      [
        'name' => 'DZONCAUICH',
        'state_id' => 31
      ],
      [
        'name' => 'ESPITA',
        'state_id' => 31
      ],
      [
        'name' => 'HALACHÓ',
        'state_id' => 31
      ],
      [
        'name' => 'HOCABÁ',
        'state_id' => 31
      ],
      [
        'name' => 'HOCTÚN',
        'state_id' => 31
      ],
      [
        'name' => 'HOMÚN',
        'state_id' => 31
      ],
      [
        'name' => 'HUHÍ',
        'state_id' => 31
      ],
      [
        'name' => 'HUNUCMÁ',
        'state_id' => 31
      ],
      [
        'name' => 'IXIL',
        'state_id' => 31
      ],
      [
        'name' => 'IZAMAL',
        'state_id' => 31
      ],
      [
        'name' => 'KANASÍN',
        'state_id' => 31
      ],
      [
        'name' => 'KANTUNIL',
        'state_id' => 31
      ],
      [
        'name' => 'KAUA',
        'state_id' => 31
      ],
      [
        'name' => 'KINCHIL',
        'state_id' => 31
      ],
      [
        'name' => 'KOPOMÁ',
        'state_id' => 31
      ],
      [
        'name' => 'MAMA',
        'state_id' => 31
      ],
      [
        'name' => 'MANÍ',
        'state_id' => 31
      ],
      [
        'name' => 'MAXCANÚ',
        'state_id' => 31
      ],
      [
        'name' => 'MAYAPÁN',
        'state_id' => 31
      ],
      [
        'name' => 'MÉRIDA',
        'state_id' => 31
      ],
      [
        'name' => 'MOCOCHÁ',
        'state_id' => 31
      ],
      [
        'name' => 'MOTUL',
        'state_id' => 31
      ],
      [
        'name' => 'MUNA',
        'state_id' => 31
      ],
      [
        'name' => 'MUXUPIP',
        'state_id' => 31
      ],
      [
        'name' => 'OPICHÉN',
        'state_id' => 31
      ],
      [
        'name' => 'OXKUTZCAB',
        'state_id' => 31
      ],
      [
        'name' => 'PANABÁ',
        'state_id' => 31
      ],
      [
        'name' => 'PETO',
        'state_id' => 31
      ],
      [
        'name' => 'PROGRESO',
        'state_id' => 31
      ],
      [
        'name' => 'QUINTANA ROO',
        'state_id' => 31
      ],
      [
        'name' => 'RÍO LAGARTOS',
        'state_id' => 31
      ],
      [
        'name' => 'SACALUM',
        'state_id' => 31
      ],
      [
        'name' => 'SAMAHIL',
        'state_id' => 31
      ],
      [
        'name' => 'SANAHCAT',
        'state_id' => 31
      ],
      [
        'name' => 'SAN FELIPE',
        'state_id' => 31
      ],
      [
        'name' => 'SANTA ELENA',
        'state_id' => 31
      ],
      [
        'name' => 'SEYÉ',
        'state_id' => 31
      ],
      [
        'name' => 'SINANCHÉ',
        'state_id' => 31
      ],
      [
        'name' => 'SOTUTA',
        'state_id' => 31
      ],
      [
        'name' => 'SUCILÁ',
        'state_id' => 31
      ],
      [
        'name' => 'SUDZAL',
        'state_id' => 31
      ],
      [
        'name' => 'SUMA',
        'state_id' => 31
      ],
      [
        'name' => 'TAHDZIÚ',
        'state_id' => 31
      ],
      [
        'name' => 'TAHMEK',
        'state_id' => 31
      ],
      [
        'name' => 'TEABO',
        'state_id' => 31
      ],
      [
        'name' => 'TECOH',
        'state_id' => 31
      ],
      [
        'name' => 'TEKAL DE VENEGAS',
        'state_id' => 31
      ],
      [
        'name' => 'TEKANTÓ',
        'state_id' => 31
      ],
      [
        'name' => 'TEKAX',
        'state_id' => 31
      ],
      [
        'name' => 'TEKIT',
        'state_id' => 31
      ],
      [
        'name' => 'TEKOM',
        'state_id' => 31
      ],
      [
        'name' => 'TELCHAC PUEBLO',
        'state_id' => 31
      ],
      [
        'name' => 'TELCHAC PUERTO',
        'state_id' => 31
      ],
      [
        'name' => 'TEMAX',
        'state_id' => 31
      ],
      [
        'name' => 'TEMOZÓN',
        'state_id' => 31
      ],
      [
        'name' => 'TEPAKÁN',
        'state_id' => 31
      ],
      [
        'name' => 'TETIZ',
        'state_id' => 31
      ],
      [
        'name' => 'TEYA',
        'state_id' => 31
      ],
      [
        'name' => 'TICUL',
        'state_id' => 31
      ],
      [
        'name' => 'TIMUCUY',
        'state_id' => 31
      ],
      [
        'name' => 'TINUM',
        'state_id' => 31
      ],
      [
        'name' => 'TIXCACALCUPUL',
        'state_id' => 31
      ],
      [
        'name' => 'TIXKOKOB',
        'state_id' => 31
      ],
      [
        'name' => 'TIXMEHUAC',
        'state_id' => 31
      ],
      [
        'name' => 'TIXPÉHUAL',
        'state_id' => 31
      ],
      [
        'name' => 'TIZIMÍN',
        'state_id' => 31
      ],
      [
        'name' => 'TUNKÁS',
        'state_id' => 31
      ],
      [
        'name' => 'TZUCACAB',
        'state_id' => 31
      ],
      [
        'name' => 'UAYMA',
        'state_id' => 31
      ],
      [
        'name' => 'UCÚ',
        'state_id' => 31
      ],
      [
        'name' => 'UMÁN',
        'state_id' => 31
      ],
      [
        'name' => 'VALLADOLID',
        'state_id' => 31
      ],
      [
        'name' => 'XOCCHEL',
        'state_id' => 31
      ],
      [
        'name' => 'YAXCABÁ',
        'state_id' => 31
      ],
      [
        'name' => 'YAXKUKUL',
        'state_id' => 31
      ],
      [
        'name' => 'YOBAÍN',
        'state_id' => 31
      ],
      [
        'name' => 'APOZOL',
        'state_id' => 32
      ],
      [
        'name' => 'APULCO',
        'state_id' => 32
      ],
      [
        'name' => 'ATOLINGA',
        'state_id' => 32
      ],
      [
        'name' => 'BENITO JUÁREZ',
        'state_id' => 32
      ],
      [
        'name' => 'CALERA',
        'state_id' => 32
      ],
      [
        'name' => 'CAÑITAS DE FELIPE PESCADOR',
        'state_id' => 32
      ],
      [
        'name' => 'CONCEPCIÓN DEL ORO',
        'state_id' => 32
      ],
      [
        'name' => 'CUAUHTÉMOC',
        'state_id' => 32
      ],
      [
        'name' => 'CHALCHIHUITES',
        'state_id' => 32
      ],
      [
        'name' => 'FRESNILLO',
        'state_id' => 32
      ],
      [
        'name' => 'TRINIDAD GARCÍA DE LA CADENA',
        'state_id' => 32
      ],
      [
        'name' => 'GENARO CODINA',
        'state_id' => 32
      ],
      [
        'name' => 'GENERAL ENRIQUE ESTRADA',
        'state_id' => 32
      ],
      [
        'name' => 'GENERAL FRANCISCO R. MURGUÍA',
        'state_id' => 32
      ],
      [
        'name' => 'EL PLATEADO DE JOAQUÍN AMARO',
        'state_id' => 32
      ],
      [
        'name' => 'GENERAL PÁNFILO NATERA',
        'state_id' => 32
      ],
      [
        'name' => 'GUADALUPE',
        'state_id' => 32
      ],
      [
        'name' => 'HUANUSCO',
        'state_id' => 32
      ],
      [
        'name' => 'JALPA',
        'state_id' => 32
      ],
      [
        'name' => 'JEREZ',
        'state_id' => 32
      ],
      [
        'name' => 'JIMÉNEZ DEL TEUL',
        'state_id' => 32
      ],
      [
        'name' => 'JUAN ALDAMA',
        'state_id' => 32
      ],
      [
        'name' => 'JUCHIPILA',
        'state_id' => 32
      ],
      [
        'name' => 'LORETO',
        'state_id' => 32
      ],
      [
        'name' => 'LUIS MOYA',
        'state_id' => 32
      ],
      [
        'name' => 'MAZAPIL',
        'state_id' => 32
      ],
      [
        'name' => 'MELCHOR OCAMPO',
        'state_id' => 32
      ],
      [
        'name' => 'MEZQUITAL DEL ORO',
        'state_id' => 32
      ],
      [
        'name' => 'MIGUEL AUZA',
        'state_id' => 32
      ],
      [
        'name' => 'MOMAX',
        'state_id' => 32
      ],
      [
        'name' => 'MONTE ESCOBEDO',
        'state_id' => 32
      ],
      [
        'name' => 'MORELOS',
        'state_id' => 32
      ],
      [
        'name' => 'MOYAHUA DE ESTRADA',
        'state_id' => 32
      ],
      [
        'name' => 'NOCHISTLÁN DE MEJÍA',
        'state_id' => 32
      ],
      [
        'name' => 'NORIA DE ÁNGELES',
        'state_id' => 32
      ],
      [
        'name' => 'OJOCALIENTE',
        'state_id' => 32
      ],
      [
        'name' => 'PÁNUCO',
        'state_id' => 32
      ],
      [
        'name' => 'PINOS',
        'state_id' => 32
      ],
      [
        'name' => 'RÍO GRANDE',
        'state_id' => 32
      ],
      [
        'name' => 'SAIN ALTO',
        'state_id' => 32
      ],
      [
        'name' => 'EL SALVADOR',
        'state_id' => 32
      ],
      [
        'name' => 'SOMBRERETE',
        'state_id' => 32
      ],
      [
        'name' => 'SUSTICACÁN',
        'state_id' => 32
      ],
      [
        'name' => 'TABASCO',
        'state_id' => 32
      ],
      [
        'name' => 'TEPECHITLÁN',
        'state_id' => 32
      ],
      [
        'name' => 'TEPETONGO',
        'state_id' => 32
      ],
      [
        'name' => 'TEÚL DE GONZÁLEZ ORTEGA',
        'state_id' => 32
      ],
      [
        'name' => 'TLALTENANGO DE SÁNCHEZ ROMÁN',
        'state_id' => 32
      ],
      [
        'name' => 'VALPARAÍSO',
        'state_id' => 32
      ],
      [
        'name' => 'VETAGRANDE',
        'state_id' => 32
      ],
      [
        'name' => 'VILLA DE COS',
        'state_id' => 32
      ],
      [
        'name' => 'VILLA GARCÍA',
        'state_id' => 32
      ],
      [
        'name' => 'VILLA GONZÁLEZ ORTEGA',
        'state_id' => 32
      ],
      [
        'name' => 'VILLA HIDALGO',
        'state_id' => 32
      ],
      [
        'name' => 'VILLANUEVA',
        'state_id' => 32
      ],
      [
        'name' => 'ZACATECAS',
        'state_id' => 32
      ],
      [
        'name' => 'TRANCOSO',
        'state_id' => 32
      ],
      [
        'name' => 'SANTA MARÍA DE LA PAZ',
        'state_id' => 32
      ]
    ];

    Municipality::insert($items);
  }
}
