<?php
/**
 * MMFF Festival - Film Import Script
 *
 * Imports all 34 films from the 2025 Migration Matters Film Festival program
 * into WordPress as 'film' custom post type entries with full meta data and taxonomy terms.
 *
 * Usage:
 *   1. Include this file in your theme's functions.php:
 *        require_once get_template_directory() . '/import-films.php';
 *   2. Navigate to WP Admin > Films > Import Films
 *   3. Click "Import All Films" to run the import
 *
 * Safety:
 *   - Requires admin privileges
 *   - Uses WordPress nonce verification
 *   - Checks for duplicate films by title before inserting
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the admin menu page
 */
function mmff_import_films_menu() {
    add_submenu_page(
        'edit.php?post_type=film',
        'Import Films',
        'Import Films',
        'manage_options',
        'mmff-import-films',
        'mmff_import_films_page'
    );
}
add_action('admin_menu', 'mmff_import_films_menu');

/**
 * Return the full film data array for the 2025 festival program.
 *
 * @return array
 */
function mmff_get_film_data() {
    return array(

        // =============================================
        // FRIDAY 20/2 - Block 1: 14:00-15:15
        // =============================================
        array(
            'title'          => "Ivan's Childhood",
            'duration'       => '12:16',
            'countries'      => array('Turkey'),
            'languages'      => array('English', 'Turkish', 'Ukrainian'),
            'categories'     => array('Short'),
            'producer'       => 'Yigit Armutoglu',
            'director'       => 'Yigit Armutoglu',
            'film_type'      => 'short',
            'screening_date' => '2025-02-20',
            'screening_time' => '14:00',
            'synopsis'       => 'A Ukrainian mother and son who fled to Turkey due to the war in their homeland confront the trauma caused by the war when they attend an event on April 23 National Sovereignty and Children\'s day for children.',
        ),
        array(
            'title'          => 'Salman Wants to Go',
            'duration'       => '20:00',
            'countries'      => array('Turkey'),
            'languages'      => array('French', 'Turkish'),
            'categories'     => array('Documentary', 'Short', 'Experimental'),
            'producer'       => 'Ozan Takis',
            'director'       => 'Ozan Takis',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-20',
            'screening_time' => '14:00',
            'synopsis'       => "Salmane, a young refugee from Senegal living in Turkey, dreams of reaching Europe\x{2014}of resuming the university studies he was forced to abandon, and of supporting the family who depends on him. Each attempt to cross the border ends in violence, his hopes beaten back. On the very day filming of this documentary was to begin, Salmane vanished. Guided by his own words and fragments stored in his phone, the documentary retraces the echoes of a life suspended between memory and disappearance. Months later, a message from Salmane reaches the filmmaker\x{2014}an unexpected return that reveals a reality more haunting than imagined.",
        ),
        array(
            'title'          => 'The Sufferers On Earth 2',
            'duration'       => '25:00',
            'countries'      => array('Turkey'),
            'languages'      => array('Arabic', 'Kurdish', 'Turkish'),
            'categories'     => array('Documentary', 'Short'),
            'producer'       => '',
            'director'       => '',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-20',
            'screening_time' => '14:00',
            'synopsis'       => 'The Osso family, who have been living in Turkey for about ten years, cannot return to their country due to distrust of the Assad regime. Although they have adapted to this place, legal uncertainties and the resulting deprivation of rights force them to seek a future abroad once again. However, the fact that a brother whose asylum application has been rejected will be left behind leaves the family facing a new separation. This is the story of a family stuck between integration and legal uncertainty, their journey shaped by the Decadences of forced migration and the testing of family ties.',
        ),
        array(
            'title'          => 'Feels Like Home',
            'duration'       => '04:59',
            'countries'      => array('Sweden'),
            'languages'      => array('Swedish'),
            'categories'     => array('Short'),
            'producer'       => 'Pedram Djafary, Lillion Lost',
            'director'       => 'Pedram Djafary, Lillion Lost',
            'film_type'      => 'short',
            'screening_date' => '2025-02-20',
            'screening_time' => '14:00',
            'synopsis'       => 'Sarah works at a hardware store. One day she meets Salim and instantly connects with him. They both share roots that might divide or unite them.',
        ),
        array(
            'title'          => 'Dog Thieves',
            'duration'       => '08:00',
            'countries'      => array('Portugal'),
            'languages'      => array('Portuguese'),
            'categories'     => array('Short'),
            'producer'       => 'Andjela Jevtovic',
            'director'       => 'Ievgen Koshyn',
            'film_type'      => 'short',
            'screening_date' => '2025-02-20',
            'screening_time' => '14:00',
            'synopsis'       => 'A middle-aged, grumpy neighbour accuses an immigrant girl of stealing his dog.',
        ),

        // =============================================
        // FRIDAY 20/2 - Block 2: 15:30-17:00
        // =============================================
        array(
            'title'          => 'War Child Chose Science',
            'duration'       => '59:00',
            'countries'      => array('Finland', 'Sierra Leone'),
            'languages'      => array('English', 'Finnish'),
            'categories'     => array('Documentary'),
            'producer'       => 'Paivi Marja Elina Kapiainen-Heiskanen',
            'director'       => '',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-20',
            'screening_time' => '15:30',
            'synopsis'       => 'The documentary film tells the story of Paul Bangura, born in Sierra Leone. He was abducted by guerrillas for 11 months during the civil war and became convinced that education will provide him with a path to career. Having studied in various countries he ended up in rural Finland to work on his thesis on Atlantic salmon. This is also a story of global migration, global food security, great emotion and the unexpected events in human life.',
        ),
        array(
            'title'          => 'KAPSUR IMRANE in New-Brunswick',
            'duration'       => '15:00',
            'countries'      => array('Canada'),
            'languages'      => array('French'),
            'categories'     => array('Documentary', 'Short'),
            'producer'       => 'Ania Jamila, Marie-France Laval',
            'director'       => '',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-20',
            'screening_time' => '15:30',
            'synopsis'       => 'In the small village of Saint Isidore in New Brunswick, Canada, lives Imrane, a bright and curious 12-year-old boy who moved from Morocco just two years ago. Between school, family time, friends and exploring the nature around him, Imrane is learning what it means to grow up in a new country. He carries with him the memories of Morocco with its flavors, stories and warmth and blends them with new friendships and fresh adventures. What does it mean to carry two cultures in one heart? Through Imrane\'s eyes, we discover how moving across the world can shape a young life and how home can exist in more than one place.',
        ),
        array(
            'title'          => 'Children of the Waves',
            'duration'       => '07:30',
            'countries'      => array('France'),
            'languages'      => array('French'),
            'categories'     => array('Documentary', 'Short'),
            'producer'       => 'Kezia Sakho',
            'director'       => '',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-20',
            'screening_time' => '15:30',
            'synopsis'       => "Noakim, Alassane, and Ilan, three young friends from Marseille, meet up after school as they always do. Amid their carefree laughter, a serious question suddenly emerges: \x{201c}What do we want to be when we grow up?\x{201d} This question sparks a deep conversation\x{2014}a heartfelt exchange about their dreams and aspirations, as they dive into a boundless world of imagination. Children of the Waves captures the beauty and fragility of childhood dreams before they are overshadowed by reality.",
        ),
        array(
            'title'          => "I'm Jesus",
            'duration'       => '01:46',
            'countries'      => array('Italy'),
            'languages'      => array('English'),
            'categories'     => array('Short'),
            'producer'       => 'Federico Cambria',
            'director'       => 'Federico Cambria',
            'film_type'      => 'short',
            'screening_date' => '2025-02-20',
            'screening_time' => '15:30',
            'synopsis'       => 'In 2024, faced with a humanity increasingly lost and a world marked by conflicts, God decides to intervene once again on Earth. But times have changed, and so has the way of communicating with people. For this new mission, He chooses an unprecedented approach: to return among human beings through His son, Jesus. This time, Jesus takes on a new and unexpected form: a young African American woman, a psychology student at Columbia University and an emerging model.',
        ),

        // =============================================
        // FRIDAY 20/2 - Block 3: 17:15-18:00
        // =============================================
        array(
            'title'          => 'Chop Chop!',
            'duration'       => '12:42',
            'countries'      => array('Estonia', 'Ireland', 'Portugal', 'Ukraine', 'United Kingdom'),
            'languages'      => array('English', 'Urdu'),
            'categories'     => array('Short'),
            'producer'       => 'Andjela Jevtovic',
            'director'       => '',
            'film_type'      => 'short',
            'screening_date' => '2025-02-20',
            'screening_time' => '17:15',
            'synopsis'       => "A Scottish-Pakistani dad's life spirals into chaos as he battles his orthodox father's ultimatum to circumcise the grandson.",
        ),
        array(
            'title'          => 'Amman',
            'duration'       => '06:30',
            'countries'      => array('Sweden'),
            'languages'      => array('Swedish'),
            'categories'     => array('Short'),
            'producer'       => '',
            'director'       => 'Isak Dizdarevic',
            'film_type'      => 'short',
            'screening_date' => '2025-02-20',
            'screening_time' => '17:15',
            'synopsis'       => 'A lonesome, immigrant printing plant worker in Southern Sweden gets wrongly accused of stealing a work tool.',
        ),
        array(
            'title'          => 'What If / Tank Om',
            'duration'       => '03:30',
            'countries'      => array('Sweden'),
            'languages'      => array('Swedish'),
            'categories'     => array('Short'),
            'producer'       => '',
            'director'       => 'Teddy Goitom',
            'film_type'      => 'short',
            'screening_date' => '2025-02-20',
            'screening_time' => '17:15',
            'synopsis'       => 'Pulsing with the rhythm of modern-day uncertainty, What If is a lyrical and visual short film exploration of doubt, prejudice, and the complex search for identity, created through innovative AI video technology. In a world constantly questioning race, gender, and social norms, the film follows Simon, a young man from Husby, on his inner journey toward understanding.',
        ),
        array(
            'title'          => 'Unfold Your Ways',
            'duration'       => '13:18',
            'countries'      => array('Sweden'),
            'languages'      => array('Swedish'),
            'categories'     => array('Documentary', 'Short'),
            'producer'       => 'Genet Solomon',
            'director'       => '',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-20',
            'screening_time' => '17:15',
            'synopsis'       => "The forest carries hidden stories\x{2014}layers of historical and cultural meaning that are often overlooked. In a Scandinavian context, the forest has long been framed as a neutral and inclusive space. We have Allemansratten, (the right of public access) so in theory, anyone can just \x{201c}go out into the forest.\x{201d} But in reality, there are invisible boundaries that shape how we move our bodies and who feels at home in nature.",
        ),

        // =============================================
        // FRIDAY 20/2 - Block 4: 18:30-20:30
        // =============================================
        array(
            'title'          => 'I Become More With You',
            'duration'       => '01:15:00',
            'countries'      => array('Sweden'),
            'languages'      => array('Swedish'),
            'categories'     => array('Feature'),
            'producer'       => '',
            'director'       => 'MyNa Do, Farah Yusuf',
            'film_type'      => 'feature',
            'screening_date' => '2025-02-20',
            'screening_time' => '18:30',
            'synopsis'       => 'Two lifelong friends fight an anti-racist battle in Sweden with art as a boundless force.',
        ),

        // =============================================
        // SATURDAY 21/2 - Block 5: 12:00-13:00
        // =============================================
        array(
            'title'          => "I'MPOSSIBLE",
            'duration'       => '33:00',
            'countries'      => array('Spain'),
            'languages'      => array('Arabic', 'English', 'Spanish'),
            'categories'     => array('Documentary'),
            'producer'       => 'Elvira Mora Lazaro, Teresa Lazaro Plaza',
            'director'       => '',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-21',
            'screening_time' => '12:00',
            'synopsis'       => "I'MPOSSIBLE follows Abdellah, Rachid, Mohamed, Toufik, and Saikou, five men who migrated to Europe in search of better opportunities and now work in the greenhouse industry of Almeria, southeast Spain. Through their testimonies, daily routines, and the use of participatory filmmaking, the film explores the link between migrant labour exploitation and the precarious living conditions in informal settlements.",
        ),

        // =============================================
        // SATURDAY 21/2 - Block 6: 13:00-13:45
        // =============================================
        array(
            'title'          => 'My Land is Burned',
            'duration'       => '30:00',
            'countries'      => array('Belgium'),
            'languages'      => array('Arabic'),
            'categories'     => array('Documentary'),
            'producer'       => '',
            'director'       => 'Abdulrahman Alshowaiki',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-21',
            'screening_time' => '13:00',
            'synopsis'       => "In Arsal, Lebanon, 'My Land is Burned' unveils the myriad challenges facing Syrian refugee children and their families. Beyond the struggles, silent acts of hope by a compassionate teacher echo an ambitious desire for a brighter, happier generation.",
        ),

        // =============================================
        // SATURDAY 21/2 - Block 7: 14:00-16:00
        // =============================================
        array(
            'title'          => 'Arbuus (Arbusto)',
            'duration'       => '10:30',
            'countries'      => array('Spain'),
            'languages'      => array('Estonian', 'Spanish'),
            'categories'     => array('Short'),
            'producer'       => '',
            'director'       => 'Gabriel Escobar Martin',
            'film_type'      => 'short',
            'screening_date' => '2025-02-21',
            'screening_time' => '14:00',
            'synopsis'       => 'In a post-apocalyptic Europe you can consider yourself lucky if you encounter some watermelons... or not.',
        ),
        array(
            'title'          => 'A Little Blackman from the Congo',
            'duration'       => '01:32:25',
            'countries'      => array('South Africa', 'Senegal', 'Spain'),
            'languages'      => array('English', 'Spanish', 'Wolof'),
            'categories'     => array('Documentary', 'Feature'),
            'producer'       => '',
            'director'       => 'Tshililo waha Muzila',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-21',
            'screening_time' => '14:00',
            'synopsis'       => 'Coming from a diverse but racially divided South Africa, filmmaker Tshililo waha Muzila visits Spain and his racial anxiety is relieved when he receives an unexpected warm welcome. This is short-lived as soon as he learns of systematic prejudices directed to an influx of West Africans displaced immigrants in the region. Using the Mediterranean migrant crisis as the canvas, Tshililo draws parallel contradictions with his personal journey and that of his son, a Spanish by birth. He sets on a Camino de Santiago, a pilgrimage not only for personal identity but tribute to the thousands of immigrants who have lost their lives in search of a better life.',
        ),

        // =============================================
        // SATURDAY 21/2 - Block 8: 16:00-17:00
        // =============================================
        array(
            'title'          => 'Shangri La, a Journey Beyond',
            'duration'       => '10:00',
            'countries'      => array('Germany'),
            'languages'      => array('German', 'English'),
            'categories'     => array('Short'),
            'producer'       => 'Nidhinkumar Paramthatta',
            'director'       => '',
            'film_type'      => 'short',
            'screening_date' => '2025-02-21',
            'screening_time' => '16:00',
            'synopsis'       => 'This world is full of Chaos and young generation is confused and confronted by the socio-economical situation around. Jonas, a young man wants to escape to another world where no sorrows exist, confused and represented along with by his own inner self. A Gypsy (representing the propaganda gang of this world) offers him a map (representing different medium for escapism, social media and co) which can lead him to the world he is dreaming of. Is that the world he is really looking for?',
        ),
        array(
            'title'          => 'A Part of Silence',
            'duration'       => '04:20',
            'countries'      => array('Sweden'),
            'languages'      => array(),
            'categories'     => array('Animation', 'Music Video', 'Short'),
            'producer'       => '',
            'director'       => '',
            'film_type'      => 'short',
            'screening_date' => '2025-02-21',
            'screening_time' => '16:00',
            'synopsis'       => '',
        ),
        array(
            'title'          => 'Healing the Mind',
            'duration'       => '04:00',
            'countries'      => array('Netherlands'),
            'languages'      => array('English'),
            'categories'     => array('Documentary'),
            'producer'       => 'Machiel Salomons, Jan-Willem Bult',
            'director'       => '',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-21',
            'screening_time' => '16:00',
            'synopsis'       => 'Ukrainian counselors in the Netherlands provide mental health care to their compatriots, many of whom are suffering from nightmares and depression from the war with Russia.',
        ),
        array(
            'title'          => 'Unspoken Proximity',
            'duration'       => '02:16',
            'countries'      => array('Sweden'),
            'languages'      => array(),
            'categories'     => array('Short', 'Experimental'),
            'producer'       => 'Genet Solomon',
            'director'       => '',
            'film_type'      => 'short',
            'screening_date' => '2025-02-21',
            'screening_time' => '16:00',
            'synopsis'       => "The film explores the body as both canvas and landscape \x{2013} a surface where memories and desires are projected. Through performative gestures and visual overlays, the work reflects on how the concept of nature contains an inherent separation. As the body shifts between subject and object, observer and observed, boundaries begin to dissolve \x{2013} between inner and outer, nature and culture, thought and matter.",
        ),
        array(
            'title'          => 'El Dorado',
            'duration'       => '01:41',
            'countries'      => array('Croatia', 'Holy See (Vatican City State)'),
            'languages'      => array('English'),
            'categories'     => array('Short', 'Experimental'),
            'producer'       => 'Bruno Pavic',
            'director'       => '',
            'film_type'      => 'short',
            'screening_date' => '2025-02-21',
            'screening_time' => '16:00',
            'synopsis'       => "Portraits of the figures in the sculpture \x{201c}Angels Unawares\x{201d} by Canadian sculptor Timothy Schmalz. A group of migrants and refugees find themselves on the high seas, traveling into the unknown, while the voice of the US president sends them instructions and warnings.",
        ),

        // =============================================
        // SATURDAY 21/2 - Block 9: 17:00
        // =============================================
        array(
            'title'          => 'NOBODY HOME',
            'duration'       => '18:18',
            'countries'      => array('Turkey', 'Germany'),
            'languages'      => array('Turkish', 'German'),
            'categories'     => array('Documentary'),
            'producer'       => 'Ilker Zor, Ibrahim Gungor',
            'director'       => '',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-21',
            'screening_time' => '17:00',
            'synopsis'       => "A forgotten migration story... A migrant's journey to his roots, the story of first-generation guest workers who migrated from Turkey to Germany in the 1960s. The lead character in the documentary travels to his village; to his memories, his childhood, his family's home. Having migrated from a village in Turkey to Germany with his mother and father 60 years ago, the protagonist returns to his roots and childhood memories, bidding farewell to his home, his village, and his memories.",
        ),

        // =============================================
        // SATURDAY 21/2 - Block 10: 17:00-18:00
        // =============================================
        array(
            'title'          => 'We Who Walk This Place',
            'duration'       => '13:46',
            'countries'      => array('Sweden'),
            'languages'      => array('Swedish'),
            'categories'     => array('Documentary'),
            'producer'       => 'Samuel Bengt Jonasson',
            'director'       => '',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-21',
            'screening_time' => '17:00',
            'synopsis'       => 'In this documentary we get to follow several high school students in a suburb in Gothenburg. Their daily lives in the school environment, reflections and discussions about everything and nothing.',
        ),

        // =============================================
        // SATURDAY 21/2 - Block 11: 19:00-21:00
        // =============================================
        array(
            'title'          => 'Lagom Svensk (Swedish Just Right)',
            'duration'       => '18:00',
            'countries'      => array('Sweden'),
            'languages'      => array('Swedish'),
            'categories'     => array('Fiction Short'),
            'producer'       => '',
            'director'       => 'Jamil Walli',
            'film_type'      => 'short',
            'screening_date' => '2025-02-21',
            'screening_time' => '19:00',
            'synopsis'       => 'After experiencing xenophobia, a Syrian guy re-enacts a verbal attack on a Swede and gets caught in a fight over what it means to be Swedish.',
        ),
        array(
            'title'          => 'Vilket Vader / This Weather',
            'duration'       => '15:11',
            'countries'      => array('Sweden'),
            'languages'      => array('Swedish', 'English'),
            'categories'     => array('Short'),
            'producer'       => '',
            'director'       => 'Korhan Kutlu, Adrian Burt',
            'film_type'      => 'short',
            'screening_date' => '2025-02-21',
            'screening_time' => '19:00',
            'synopsis'       => 'Jami, a Middle Eastern refugee and lonely taxi driver in Stockholm, goes through his routine of picking up passengers while struggling with self-imposed isolation and grief over his lost family. One of the passengers is Siri, a mysterious young woman who encourages Jami to open up. At her request, they sit down for coffee, and for the first time, Jami shares his painful past. After dropping her off, he realizes Siri was never really there. After this revelation, Jami feels changed and drives off with a new sense of openness, ready to engage with his next passenger.',
        ),

        // =============================================
        // SUNDAY 22/2 - Block 12: 12:00-13:00
        // =============================================
        array(
            'title'          => 'The Health of Those Who Care. Stories of Migrant Women',
            'duration'       => '38:00',
            'countries'      => array('Argentina'),
            'languages'      => array('Spanish'),
            'categories'     => array('Documentary'),
            'producer'       => '',
            'director'       => 'Agustina Bordigoni',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-22',
            'screening_time' => '12:00',
            'synopsis'       => '"The Health of Those Who Care" is a documentary that depicts the story of 9 women who migrated to Argentina for different reasons and \x{2013} in their own ways \x{2013} work as home caregivers or health care professionals.',
        ),

        // =============================================
        // SUNDAY 22/2 - Block 13: 13:00-13:30
        // =============================================
        array(
            'title'          => 'NEW CLASSMATES',
            'duration'       => '01:29:30',
            'countries'      => array('Slovenia'),
            'languages'      => array('Albanian', 'English', 'Slovenian'),
            'categories'     => array('Documentary'),
            'producer'       => '',
            'director'       => 'Toni Cahunek, Andraz Poeschl, Jure Vizjak',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-22',
            'screening_time' => '13:00',
            'synopsis'       => 'The Slovenian economy relies on workers from Kosovo, but how can the education system support their children? This documentary offers an insightful look into the background of immigration and the challenges of integrating immigrants from Kosovo into the Slovenian school system. The film follows the journey of four Albanian-speaking children from Kosovo as they navigate the Slovenian school system with no prior knowledge of the language and significant educational gaps.',
        ),

        // =============================================
        // SUNDAY 22/2 - Block 14: 15:00-17:00
        // =============================================
        array(
            'title'          => 'Lebanon by Night',
            'duration'       => '01:49:57',
            'countries'      => array('Lebanon'),
            'languages'      => array('Arabic'),
            'categories'     => array('Documentary'),
            'producer'       => 'Caroline Hatem',
            'director'       => '',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-22',
            'screening_time' => '15:00',
            'synopsis'       => 'In recent years, municipalities across Lebanon imposed curfews restricting the freedom of movement of male Syrian workers who were banned from walking the streets after dark. Filmed in Lebanon, Lebanon by Night uncovers the different layers of Lebanese and Syrian experience in relation to the curfew through a range of locations and characters\x{2014}from local residents and migrant workers to local community figures and sectarian vigilante groups imposing curfews as they see fit.',
        ),

        // =============================================
        // SUNDAY 22/2 - Block 15: 17:15-18:20
        // =============================================
        array(
            'title'          => 'Homenagem',
            'duration'       => '01:17:05',
            'countries'      => array('Portugal'),
            'languages'      => array('French', 'Portuguese'),
            'categories'     => array('Documentary'),
            'producer'       => '',
            'director'       => 'Chiara Cassaghi',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-22',
            'screening_time' => '17:15',
            'synopsis'       => 'Fifty years after the Revolution, a border region of Portugal, emptied out by clandestine immigration, still faces the struggles of population loss.',
        ),

        // =============================================
        // SUNDAY 22/2 - Block 16: 18:30-19:15
        // =============================================
        array(
            'title'          => 'Hope for Ukraine',
            'duration'       => '00:17:48',
            'countries'      => array('Norway', 'Ukraine'),
            'languages'      => array('English', 'Ukrainian'),
            'categories'     => array('Documentary'),
            'producer'       => 'Andreas Langvatn',
            'director'       => '',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-22',
            'screening_time' => '18:30',
            'synopsis'       => 'A docudrama with an important message. Vitaly, a father of two has to leave his family to a land they supposed to meet. If they ever meet there remains to see. On the way he ends up on the street and needs help to get back on the road.',
        ),
        array(
            'title'          => 'The Wrong Side',
            'duration'       => '14:58',
            'countries'      => array('Poland', 'Ukraine'),
            'languages'      => array('Ukrainian'),
            'categories'     => array('Short'),
            'producer'       => 'Nikoletta Olenchyn, Blaise Burski',
            'director'       => '',
            'film_type'      => 'short',
            'screening_date' => '2025-02-22',
            'screening_time' => '18:30',
            'synopsis'       => '"The Wrong Side" is an intimate story about a woman torn between keeping her family together and ensuring the safety of her daughter. Lesia, a young mother, lives in a country ravaged by war. As the threat intensifies and soldiers begin appearing at their doorstep, Lesia not only grapples with difficult decisions but also with increasingly strained family relationships.',
        ),

        // =============================================
        // SUNDAY 22/2 - Block 17: 19:30-20:30
        // =============================================
        array(
            'title'          => 'Living with the Taliban',
            'duration'       => '53:00',
            'countries'      => array('Poland'),
            'languages'      => array('English', 'Pashto (Pushto)'),
            'categories'     => array('Documentary'),
            'producer'       => '',
            'director'       => 'Siarhei Marchyk, Witold Repetowicz',
            'film_type'      => 'documentary',
            'screening_date' => '2025-02-22',
            'screening_time' => '19:30',
            'synopsis'       => "Living with the Taliban offers a powerful glimpse into life in Afghanistan after the Taliban's return to power in 2021. Through personal stories, the film portrays both the supporters of the new regime and those whose lives have been tragically altered, capturing the country's ongoing struggle between hope and despair.",
        ),

    ); // end films array
}

/**
 * Check if a film already exists by its exact title.
 *
 * @param string $title The film title to search for.
 * @return int|false Post ID if found, false otherwise.
 */
function mmff_film_exists($title) {
    global $wpdb;

    $post_id = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts} WHERE post_title = %s AND post_type = %s AND post_status IN ('publish', 'draft', 'pending', 'private') LIMIT 1",
            $title,
            'film'
        )
    );

    return $post_id ? (int) $post_id : false;
}

/**
 * Ensure a taxonomy term exists and return its ID.
 *
 * @param string $term_name The term name.
 * @param string $taxonomy  The taxonomy slug.
 * @return int The term ID.
 */
function mmff_ensure_term($term_name, $taxonomy) {
    $term_name = trim($term_name);
    if (empty($term_name)) {
        return 0;
    }

    $existing = term_exists($term_name, $taxonomy);
    if ($existing) {
        return is_array($existing) ? (int) $existing['term_id'] : (int) $existing;
    }

    $result = wp_insert_term($term_name, $taxonomy);
    if (is_wp_error($result)) {
        // If term already exists under a different slug, try to get it
        $existing = get_term_by('name', $term_name, $taxonomy);
        if ($existing) {
            return (int) $existing->term_id;
        }
        return 0;
    }

    return (int) $result['term_id'];
}

/**
 * Import a single film into WordPress.
 *
 * @param array $film Film data array.
 * @return array Result with status, message, and post_id.
 */
function mmff_import_single_film($film) {
    // Check for duplicates
    $existing_id = mmff_film_exists($film['title']);
    if ($existing_id) {
        return array(
            'status'  => 'skipped',
            'message' => sprintf('Film "%s" already exists (ID: %d)', $film['title'], $existing_id),
            'post_id' => $existing_id,
        );
    }

    // Prepare the post
    $post_data = array(
        'post_title'   => sanitize_text_field($film['title']),
        'post_content' => wp_kses_post($film['synopsis']),
        'post_status'  => 'publish',
        'post_type'    => 'film',
    );

    $post_id = wp_insert_post($post_data, true);

    if (is_wp_error($post_id)) {
        return array(
            'status'  => 'error',
            'message' => sprintf('Failed to import "%s": %s', $film['title'], $post_id->get_error_message()),
            'post_id' => 0,
        );
    }

    // Set post meta fields
    if (!empty($film['duration'])) {
        update_post_meta($post_id, '_film_duration', sanitize_text_field($film['duration']));
    }
    if (!empty($film['director'])) {
        update_post_meta($post_id, '_film_director', sanitize_text_field($film['director']));
    }
    if (!empty($film['producer'])) {
        update_post_meta($post_id, '_film_producer', sanitize_text_field($film['producer']));
    }
    if (!empty($film['film_type'])) {
        update_post_meta($post_id, '_film_type', sanitize_text_field($film['film_type']));
    }
    if (!empty($film['screening_date'])) {
        update_post_meta($post_id, '_film_screening_date', sanitize_text_field($film['screening_date']));
    }
    if (!empty($film['screening_time'])) {
        update_post_meta($post_id, '_film_screening_time', sanitize_text_field($film['screening_time']));
    }

    // Set film_year taxonomy (all are 2025)
    wp_set_object_terms($post_id, '2025', 'film_year');

    // Set film_country taxonomy
    if (!empty($film['countries'])) {
        $country_term_ids = array();
        foreach ($film['countries'] as $country) {
            $tid = mmff_ensure_term($country, 'film_country');
            if ($tid) {
                $country_term_ids[] = $tid;
            }
        }
        if (!empty($country_term_ids)) {
            wp_set_object_terms($post_id, $country_term_ids, 'film_country');
        }
    }

    // Set film_language taxonomy
    if (!empty($film['languages'])) {
        $language_term_ids = array();
        foreach ($film['languages'] as $language) {
            $tid = mmff_ensure_term($language, 'film_language');
            if ($tid) {
                $language_term_ids[] = $tid;
            }
        }
        if (!empty($language_term_ids)) {
            wp_set_object_terms($post_id, $language_term_ids, 'film_language');
        }
    }

    // Set film_category taxonomy
    if (!empty($film['categories'])) {
        $category_term_ids = array();
        foreach ($film['categories'] as $category) {
            $tid = mmff_ensure_term($category, 'film_category');
            if ($tid) {
                $category_term_ids[] = $tid;
            }
        }
        if (!empty($category_term_ids)) {
            wp_set_object_terms($post_id, $category_term_ids, 'film_category');
        }
    }

    return array(
        'status'  => 'imported',
        'message' => sprintf('Successfully imported "%s" (ID: %d)', $film['title'], $post_id),
        'post_id' => $post_id,
    );
}

/**
 * Render the admin page for importing films.
 */
function mmff_import_films_page() {
    // Security check
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    $results    = array();
    $imported   = false;

    // Handle the import action
    if (isset($_POST['mmff_import_films_submit']) && check_admin_referer('mmff_import_films_action', 'mmff_import_films_nonce')) {
        $imported = true;
        $films    = mmff_get_film_data();

        foreach ($films as $film) {
            $results[] = mmff_import_single_film($film);
        }
    }

    // Count results by status
    $count_imported = 0;
    $count_skipped  = 0;
    $count_errors   = 0;

    foreach ($results as $r) {
        switch ($r['status']) {
            case 'imported':
                $count_imported++;
                break;
            case 'skipped':
                $count_skipped++;
                break;
            case 'error':
                $count_errors++;
                break;
        }
    }

    ?>
    <div class="wrap">
        <h1>MMFF 2025 Film Import</h1>
        <p>This tool imports all 34 films from the 2025 Migration Matters Film Festival program into the WordPress database as <code>film</code> post type entries.</p>

        <div class="card" style="max-width: 800px; padding: 20px; margin-bottom: 20px;">
            <h2>What will be imported:</h2>
            <ul style="list-style: disc; padding-left: 20px;">
                <li><strong>34 films</strong> across 3 festival days (Feb 20-22, 2025)</li>
                <li><strong>Post meta:</strong> duration, director, producer, film type, screening date, screening time</li>
                <li><strong>Taxonomies:</strong> film_year (2025), film_country, film_language, film_category</li>
                <li><strong>Post content:</strong> synopsis text for each film</li>
            </ul>
            <p><em>Films that already exist (matched by title) will be skipped to prevent duplicates.</em></p>
        </div>

        <?php if ($imported) : ?>

            <div class="notice notice-info" style="padding: 12px; margin-bottom: 20px;">
                <h2 style="margin-top: 0;">Import Results</h2>
                <p>
                    <span style="color: #00a32a; font-weight: 600;">Imported: <?php echo esc_html($count_imported); ?></span> &nbsp;|&nbsp;
                    <span style="color: #dba617; font-weight: 600;">Skipped (duplicates): <?php echo esc_html($count_skipped); ?></span> &nbsp;|&nbsp;
                    <span style="color: #d63638; font-weight: 600;">Errors: <?php echo esc_html($count_errors); ?></span> &nbsp;|&nbsp;
                    <strong>Total processed: <?php echo esc_html(count($results)); ?></strong>
                </p>
            </div>

            <table class="widefat striped" style="max-width: 1000px;">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th style="width: 80px;">Status</th>
                        <th>Film Title</th>
                        <th style="width: 100px;">Post ID</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $index => $r) : ?>
                        <tr>
                            <td><?php echo esc_html($index + 1); ?></td>
                            <td>
                                <?php
                                switch ($r['status']) {
                                    case 'imported':
                                        echo '<span style="color: #00a32a; font-weight: bold;">Imported</span>';
                                        break;
                                    case 'skipped':
                                        echo '<span style="color: #dba617; font-weight: bold;">Skipped</span>';
                                        break;
                                    case 'error':
                                        echo '<span style="color: #d63638; font-weight: bold;">Error</span>';
                                        break;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($r['post_id'] && $r['status'] !== 'error') {
                                    $edit_link = get_edit_post_link($r['post_id']);
                                    echo '<a href="' . esc_url($edit_link) . '">' . esc_html($r['message']) . '</a>';
                                } else {
                                    echo esc_html($r['message']);
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo $r['post_id'] ? esc_html($r['post_id']) : '&mdash;'; ?>
                            </td>
                            <td><?php echo esc_html($r['message']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="margin-top: 20px;">
                <a href="<?php echo esc_url(admin_url('edit.php?post_type=film')); ?>" class="button button-primary">View All Films</a>
                <a href="<?php echo esc_url(admin_url('admin.php?page=mmff-import-films')); ?>" class="button">Run Import Again</a>
            </div>

        <?php else : ?>

            <form method="post" action="">
                <?php wp_nonce_field('mmff_import_films_action', 'mmff_import_films_nonce'); ?>

                <h2>Preview: Films to Import</h2>
                <table class="widefat striped" style="max-width: 1200px;">
                    <thead>
                        <tr>
                            <th style="width: 30px;">#</th>
                            <th>Title</th>
                            <th>Duration</th>
                            <th>Country</th>
                            <th>Language(s)</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $films        = mmff_get_film_data();
                        $preview_new  = 0;
                        $preview_dup  = 0;

                        foreach ($films as $index => $film) :
                            $exists = mmff_film_exists($film['title']);
                            if ($exists) {
                                $preview_dup++;
                            } else {
                                $preview_new++;
                            }
                        ?>
                            <tr>
                                <td><?php echo esc_html($index + 1); ?></td>
                                <td><strong><?php echo esc_html($film['title']); ?></strong></td>
                                <td><?php echo esc_html($film['duration']); ?></td>
                                <td><?php echo esc_html(implode(', ', $film['countries'])); ?></td>
                                <td><?php echo esc_html(implode(', ', $film['languages'])); ?></td>
                                <td><?php echo esc_html($film['film_type']); ?></td>
                                <td><?php echo esc_html($film['screening_date']); ?></td>
                                <td><?php echo esc_html($film['screening_time']); ?></td>
                                <td>
                                    <?php if ($exists) : ?>
                                        <span style="color: #dba617;">Exists (ID: <?php echo esc_html($exists); ?>)</span>
                                    <?php else : ?>
                                        <span style="color: #00a32a;">New</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div style="margin-top: 15px; padding: 12px; background: #f0f0f1; border-left: 4px solid #2271b1; max-width: 1200px;">
                    <strong>Summary:</strong>
                    <?php echo esc_html($preview_new); ?> new film(s) will be imported.
                    <?php if ($preview_dup > 0) : ?>
                        <?php echo esc_html($preview_dup); ?> film(s) already exist and will be skipped.
                    <?php endif; ?>
                </div>

                <p style="margin-top: 20px;">
                    <input type="submit"
                           name="mmff_import_films_submit"
                           class="button button-primary button-hero"
                           value="Import All Films"
                           onclick="return confirm('This will import <?php echo esc_attr($preview_new); ?> films into WordPress. Continue?');"
                    />
                </p>
            </form>

        <?php endif; ?>
    </div>
    <?php
}

/**
 * Also support the ?import_films=1 query parameter for quick access.
 * Must be logged in as admin. Redirects to the admin import page.
 */
function mmff_import_films_query_param_redirect() {
    if (isset($_GET['import_films']) && $_GET['import_films'] === '1') {
        if (is_user_logged_in() && current_user_can('manage_options')) {
            wp_safe_redirect(admin_url('admin.php?page=mmff-import-films'));
            exit;
        }
    }
}
add_action('template_redirect', 'mmff_import_films_query_param_redirect');
