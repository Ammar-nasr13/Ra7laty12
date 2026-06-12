// ================================================================
//  TRIPS DATA — Static data for all trips
//  Each trip has attributes that match the survey answers
// ================================================================

const STATIC_TRIPS = [
    // ===== EGYPTIAN TRIPS =====
    {
        id: 1,
        title_ar: 'غردقة الساحرة',
        title_en: 'Magical Hurghada',
        country_ar: 'مصر', country_en: 'Egypt', flag: '🇪🇬',
        price: 350, currency: '$',
        duration: 5,
        category: 'beach',
        climate: 'beach',
        travel_type: ['family', 'couple', 'friends'],
        budget_tier: 'low',
        color_from: '#0099CC', color_to: '#FF6633',
        is_egyptian: true,
        spots_total: 20, spots_left: 5,
        departure_dates: ['2026-04-20','2026-05-10','2026-06-05','2026-07-01'],
        desc_ar: 'استمتع بشواطئ الغردقة الرائعة وغوص في أعماق البحر الأحمر، رحلة لا تُنسى بأسعار مناسبة.',
        desc_en: 'Enjoy the stunning beaches of Hurghada and dive into the Red Sea depths — an unforgettable trip at affordable prices.',
        highlights_ar: ['غوص وسنوركل', 'رياضات مائية', 'رحلة صحراوية', 'كورنيش الغردقة'],
        highlights_en: ['Diving & Snorkeling', 'Water Sports', 'Desert Safari', 'Hurghada Corniche'],
    },
    {
        id: 2,
        title_ar: 'شرم الشيخ الأسطوري',
        title_en: 'Legendary Sharm El-Sheikh',
        country_ar: 'مصر', country_en: 'Egypt', flag: '🇪🇬',
        price: 420, currency: '$',
        duration: 6,
        category: 'beach',
        climate: 'beach',
        travel_type: ['couple', 'family', 'friends'],
        budget_tier: 'low',
        color_from: '#00B4D8', color_to: '#F77F00',
        is_egyptian: true,
        spots_total: 18, spots_left: 3,
        departure_dates: ['2026-04-25','2026-05-15','2026-06-10'],
        desc_ar: 'جنة الشعاب المرجانية وأجمل شواطئ مصر في رحلة مثيرة بين الجبال والبحر.',
        desc_en: 'Paradise of coral reefs and Egypt\'s most beautiful beaches in an exciting journey between mountains and sea.',
        highlights_ar: ['نعمة باي', 'جزيرة تيران', 'سوق شرم', 'رحلة الصحراء'],
        highlights_en: ['Naama Bay', 'Tiran Island', 'Sharm Market', 'Desert Trip'],
    },
    {
        id: 3,
        title_ar: 'الأقصر وأسوان — أرض الفراعنة',
        title_en: 'Luxor & Aswan — Land of Pharaohs',
        country_ar: 'مصر', country_en: 'Egypt', flag: '🇪🇬',
        price: 500, currency: '$',
        duration: 7,
        category: 'culture',
        climate: 'desert',
        travel_type: ['family', 'couple', 'solo'],
        budget_tier: 'medium',
        color_from: '#8B4513', color_to: '#C5A028',
        is_egyptian: true,
        spots_total: 15, spots_left: 9,
        departure_dates: ['2026-05-01','2026-05-22','2026-07-03'],
        desc_ar: 'رحلة في أعماق التاريخ المصري القديم بين معابد الكرنك وأبو سمبل والمتحف الفرعوني.',
        desc_en: 'A journey into ancient Egyptian history between Karnak temples, Abu Simbel, and the Pharaonic museum.',
        highlights_ar: ['معبد الكرنك', 'أبو سمبل', 'وادي الملوك', 'رحلة النيل'],
        highlights_en: ['Karnak Temple', 'Abu Simbel', 'Valley of Kings', 'Nile Cruise'],
    },
    // ===== EUROPEAN TRIPS =====
    {
        id: 4,
        title_ar: 'باريس — مدينة الأنوار',
        title_en: 'Paris — City of Lights',
        country_ar: 'فرنسا', country_en: 'France', flag: '🇫🇷',
        price: 1500, currency: '$',
        duration: 7,
        category: 'culture',
        climate: 'city',
        travel_type: ['couple', 'solo'],
        budget_tier: 'high',
        color_from: '#003087', color_to: '#ED2939',
        is_egyptian: false,
        spots_total: 20, spots_left: 12,
        departure_dates: ['2026-05-05','2026-06-12','2026-07-10'],
        desc_ar: 'استكشف عاصمة الفنون والموضة، من برج إيفل إلى متحف اللوفر في رحلة رومانسية لا مثيل لها.',
        desc_en: 'Explore the capital of arts and fashion, from the Eiffel Tower to the Louvre in an unparalleled romantic journey.',
        highlights_ar: ['برج إيفل', 'متحف اللوفر', 'الشانزليزيه', 'قصر فرساي'],
        highlights_en: ['Eiffel Tower', 'Louvre Museum', 'Champs-Élysées', 'Palace of Versailles'],
    },
    {
        id: 5,
        title_ar: 'روما — العاصمة الأبدية',
        title_en: 'Rome — The Eternal City',
        country_ar: 'إيطاليا', country_en: 'Italy', flag: '🇮🇹',
        price: 1300, currency: '$',
        duration: 6,
        category: 'culture',
        climate: 'city',
        travel_type: ['couple', 'family', 'solo'],
        budget_tier: 'high',
        color_from: '#009246', color_to: '#CE2B37',
        is_egyptian: false,
        spots_total: 16, spots_left: 7,
        departure_dates: ['2026-04-28','2026-06-01','2026-07-18'],
        desc_ar: 'تجول في شوارع التاريخ بين الكولوسيوم والفاتيكان وينابيع تريفي في مدينة خالدة.',
        desc_en: 'Walk through streets of history between the Colosseum, Vatican, and Trevi Fountain in an eternal city.',
        highlights_ar: ['الكولوسيوم', 'الفاتيكان', 'نافورة تريفي', 'البانثيون'],
        highlights_en: ['Colosseum', 'Vatican City', 'Trevi Fountain', 'Pantheon'],
    },
    {
        id: 6,
        title_ar: 'برشلونة — مدينة الفن',
        title_en: 'Barcelona — City of Art',
        country_ar: 'إسبانيا', country_en: 'Spain', flag: '🇪🇸',
        price: 1200, currency: '$',
        duration: 6,
        category: 'adventure',
        climate: 'beach',
        travel_type: ['friends', 'couple', 'solo'],
        budget_tier: 'high',
        color_from: '#AA151B', color_to: '#F1BF00',
        is_egyptian: false,
        spots_total: 20, spots_left: 14,
        departure_dates: ['2026-05-08','2026-06-20','2026-08-01'],
        desc_ar: 'من معمار غاودي الفريد إلى شواطئ لا باركيتا المذهلة، برشلونة تجمع الفن والمتعة معاً.',
        desc_en: 'From Gaudí\'s unique architecture to the stunning beaches of La Barceloneta, Barcelona combines art and fun.',
        highlights_ar: ['الساغرادا فاميليا', 'لاس رامبلاس', 'شاطئ برشلونة', 'الحي القوطي'],
        highlights_en: ['Sagrada Família', 'Las Ramblas', 'Barcelona Beach', 'Gothic Quarter'],
    },
    // ===== ASIA & MIDDLE EAST =====
    {
        id: 7,
        title_ar: 'دبي — مدينة المستقبل',
        title_en: 'Dubai — City of the Future',
        country_ar: 'الإمارات', country_en: 'UAE', flag: '🇦🇪',
        price: 900, currency: '$',
        duration: 5,
        category: 'adventure',
        climate: 'desert',
        travel_type: ['family', 'couple', 'friends'],
        budget_tier: 'high',
        color_from: '#00732F', color_to: '#C0392B',
        is_egyptian: false,
        spots_total: 25, spots_left: 2,
        departure_dates: ['2026-04-22','2026-05-18','2026-06-25'],
        desc_ar: 'تسوق في أفخم المراكز التجارية وتزلج على الثلج بينما الصحراء تمتد خارج النافذة.',
        desc_en: 'Shop in the most luxurious malls and ski on snow while the desert stretches outside the window.',
        highlights_ar: ['برج خليفة', 'دبي مول', 'ميناء جميرا', 'رحلة الصحراء'],
        highlights_en: ['Burj Khalifa', 'Dubai Mall', 'Jumeirah Port', 'Desert Safari'],
    },
    {
        id: 8,
        title_ar: 'إسطنبول — جسر الحضارات',
        title_en: 'Istanbul — Bridge of Civilizations',
        country_ar: 'تركيا', country_en: 'Turkey', flag: '🇹🇷',
        price: 700, currency: '$',
        duration: 6,
        category: 'culture',
        climate: 'city',
        travel_type: ['family', 'couple', 'friends', 'solo'],
        budget_tier: 'medium',
        color_from: '#E30A17', color_to: '#2E4053',
        is_egyptian: false,
        spots_total: 22, spots_left: 10,
        departure_dates: ['2026-05-03','2026-05-28','2026-07-05'],
        desc_ar: 'مدينة تجمع بين شرق وغرب، بين آيا صوفيا والبسفور والبازارات الشرقية العريقة.',
        desc_en: 'A city that brings together East and West, between Hagia Sophia, the Bosphorus, and ancient Eastern bazaars.',
        highlights_ar: ['آيا صوفيا', 'القصر الكبير', 'البازار المسقوف', 'جسر البسفور'],
        highlights_en: ['Hagia Sophia', 'Topkapi Palace', 'Grand Bazaar', 'Bosphorus Bridge'],
    },
    {
        id: 9,
        title_ar: 'بالي — جنة الأرض',
        title_en: 'Bali — Heaven on Earth',
        country_ar: 'إندونيسيا', country_en: 'Indonesia', flag: '🇮🇩',
        price: 800, currency: '$',
        duration: 10,
        category: 'beach',
        climate: 'beach',
        travel_type: ['couple', 'friends', 'solo'],
        budget_tier: 'medium',
        color_from: '#FF6B35', color_to: '#1A936F',
        is_egyptian: false,
        spots_total: 18, spots_left: 6,
        departure_dates: ['2026-05-12','2026-06-09','2026-08-11'],
        desc_ar: 'جزيرة الآلهة ذات المعابد والشلالات والشواطئ البركانية الخلابة وثقافة فريدة من نوعها.',
        desc_en: 'Island of the gods with temples, waterfalls, volcanic beaches, and a unique culture like no other.',
        highlights_ar: ['معبد أولوواتو', 'تراسات أوبود', 'شاطئ كوتا', 'كانيون أيانغ'],
        highlights_en: ['Uluwatu Temple', 'Ubud Terraces', 'Kuta Beach', 'Ayung Canyon'],
    },
    // ===== AMERICAS =====
    {
        id: 10,
        title_ar: 'نيويورك — المدينة التي لا تنام',
        title_en: 'New York — The City That Never Sleeps',
        country_ar: 'أمريكا', country_en: 'USA', flag: '🇺🇸',
        price: 2500, currency: '$',
        duration: 8,
        category: 'adventure',
        climate: 'city',
        travel_type: ['friends', 'couple', 'solo'],
        budget_tier: 'luxury',
        color_from: '#3C3B6E', color_to: '#B22234',
        is_egyptian: false,
        spots_total: 15, spots_left: 8,
        departure_dates: ['2026-05-20','2026-07-01','2026-09-05'],
        desc_ar: 'تجربة المدينة الأكثر إثارة في العالم، من تايمز سكوير إلى سنترال بارك والمتحف الأمريكي.',
        desc_en: 'Experience the most exciting city in the world, from Times Square to Central Park and the American Museum.',
        highlights_ar: ['تايمز سكوير', 'سنترال بارك', 'تمثال الحرية', 'الطريق السريع الأمريكي'],
        highlights_en: ['Times Square', 'Central Park', 'Statue of Liberty', 'Broadway'],
    },
    {
        id: 11,
        title_ar: 'المالديف — المتعة الخالصة',
        title_en: 'Maldives — Pure Paradise',
        country_ar: 'المالديف', country_en: 'Maldives', flag: '🇲🇻',
        price: 3000, currency: '$',
        duration: 7,
        category: 'beach',
        climate: 'beach',
        travel_type: ['couple'],
        budget_tier: 'luxury',
        color_from: '#006994', color_to: '#00C9A7',
        is_egyptian: false,
        spots_total: 10, spots_left: 1,
        departure_dates: ['2026-05-01','2026-06-15','2026-10-03'],
        desc_ar: 'جزر المحيط الهندي الخيالية مع أكواخ فوق الماء وشعاب مرجانية بلورية وغروب شمس لا يوصف.',
        desc_en: 'Dreamy Indian Ocean islands with overwater bungalows, crystal coral reefs, and indescribable sunsets.',
        highlights_ar: ['كوخ فوق الماء', 'الغوص في المرجان', 'غروب المحيط', 'سبا خاص'],
        highlights_en: ['Overwater Bungalow', 'Coral Diving', 'Ocean Sunset', 'Private Spa'],
    },
    {
        id: 12,
        title_ar: 'طوكيو — عاصمة المستقبل',
        title_en: 'Tokyo — Capital of the Future',
        country_ar: 'اليابان', country_en: 'Japan', flag: '🇯🇵',
        price: 2200, currency: '$',
        duration: 9,
        category: 'culture',
        climate: 'city',
        travel_type: ['solo', 'couple', 'friends'],
        budget_tier: 'luxury',
        color_from: '#BC002D', color_to: '#2C3E50',
        is_egyptian: false,
        spots_total: 20, spots_left: 11,
        departure_dates: ['2026-05-15','2026-07-22','2026-09-17'],
        desc_ar: 'مزيج مذهل بين التكنولوجيا الحديثة والتراث الياباني الأصيل في مدينة لا تشبه أي مكان آخر.',
        desc_en: 'An amazing blend of modern technology and authentic Japanese heritage in a city unlike anywhere else.',
        highlights_ar: ['جبل فوجي', 'شينجوكو', 'معبد سنسوجي', 'حي أكيهابارا'],
        highlights_en: ['Mount Fuji', 'Shinjuku', 'Senso-ji Temple', 'Akihabara District'],
    },
    {
        id: 13,
        title_ar: 'المغرب — مملكة الألوان',
        title_en: 'Morocco — Kingdom of Colors',
        country_ar: 'المغرب', country_en: 'Morocco', flag: '🇲🇦',
        price: 600, currency: '$',
        duration: 7,
        category: 'adventure',
        climate: 'desert',
        travel_type: ['friends', 'family', 'solo'],
        budget_tier: 'medium',
        color_from: '#C1272D', color_to: '#006233',
        is_egyptian: false,
        spots_total: 20, spots_left: 15,
        departure_dates: ['2026-04-24','2026-05-22','2026-06-19'],
        desc_ar: 'من أزقة مراكش الوردية إلى صحراء الصحراء الكبرى وشاطئ أغادير المدهش، رحلة بألف لون.',
        desc_en: 'From the pink alleys of Marrakech to the Sahara Desert and stunning Agadir beach — a journey of a thousand colors.',
        highlights_ar: ['جامع الفنا', 'الصحراء الكبرى', 'فاس القديمة', 'شاطئ أغادير'],
        highlights_en: ['Jemaa el-Fna', 'Sahara Desert', 'Ancient Fez', 'Agadir Beach'],
    },
    {
        id: 14,
        title_ar: 'جزر اليونان — أجمل شواطئ أوروبا',
        title_en: 'Greek Islands — Europe\'s Most Beautiful Beaches',
        country_ar: 'اليونان', country_en: 'Greece', flag: '🇬🇷',
        price: 1100, currency: '$',
        duration: 8,
        category: 'beach',
        climate: 'beach',
        travel_type: ['couple', 'friends'],
        budget_tier: 'high',
        color_from: '#0D5EAF', color_to: '#FFFFFF',
        is_egyptian: false,
        spots_total: 16, spots_left: 4,
        departure_dates: ['2026-05-07','2026-06-04','2026-07-02'],
        desc_ar: 'سانتوريني الحالمة وميكونوس الصاخبة وجزر الإيجه الخلابة في رحلة بحرية فريدة.',
        desc_en: 'Dreamy Santorini and vibrant Mykonos and stunning Aegean islands in a unique sea journey.',
        highlights_ar: ['سانتوريني', 'ميكونوس', 'جزيرة كريت', 'أكروبوليس أثينا'],
        highlights_en: ['Santorini', 'Mykonos', 'Crete Island', 'Athens Acropolis'],
    },
    {
        id: 15,
        title_ar: 'البر السويسري — قلب الألب',
        title_en: 'Switzerland — Heart of the Alps',
        country_ar: 'سويسرا', country_en: 'Switzerland', flag: '🇨🇭',
        price: 2800, currency: '$',
        duration: 8,
        category: 'adventure',
        climate: 'mountain',
        travel_type: ['family', 'couple'],
        budget_tier: 'luxury',
        color_from: '#D52B1E', color_to: '#FFFFFF',
        is_egyptian: false,
        spots_total: 12, spots_left: 5,
        departure_dates: ['2026-06-01','2026-07-15','2026-08-22'],
        desc_ar: 'تزلج على جبال الألب وتجول في قرى الشوكولاتة وبحيرة جنيف الرائعة في قلب أوروبا.',
        desc_en: 'Ski in the Alps, stroll through chocolate villages, and visit stunning Lake Geneva in the heart of Europe.',
        highlights_ar: ['جبل يونغفراو', 'زيرمات', 'بحيرة جنيف', 'إنترلاكن'],
        highlights_en: ['Jungfrau Mountain', 'Zermatt', 'Lake Geneva', 'Interlaken'],
    },
    {
        id: 16,
        title_ar: 'البانيا — الكنز الخفي',
        title_en: 'Albania — The Hidden Gem',
        country_ar: 'ألبانيا', country_en: 'Albania', flag: '🇦🇱',
        price: 450, currency: '$',
        duration: 6,
        category: 'beach',
        climate: 'beach',
        travel_type: ['friends', 'solo', 'couple'],
        budget_tier: 'low',
        color_from: '#E41E20', color_to: '#1A3A5C',
        is_egyptian: false,
        spots_total: 25, spots_left: 18,
        departure_dates: ['2026-04-30','2026-05-28','2026-06-25'],
        desc_ar: 'شواطئ البحر الأدرياتيكي والمتوسط بأسعار لا تُصدق وجمال طبيعي بكر لم يكتشفه الكثيرون.',
        desc_en: 'Adriatic and Mediterranean beaches at unbelievable prices with pristine natural beauty few have discovered.',
        highlights_ar: ['شاطئ كاميل', 'جيروكاستر', 'بحيرة شكودر', 'ساراندا'],
        highlights_en: ['Ksamil Beach', 'Gjirokastër', 'Lake Shkodër', 'Saranda'],
    },
];

// Use live DB data injected by the layout, fall back to static array
export const TRIPS_DATA = (window.__DB_TRIPS && window.__DB_TRIPS.length)
    ? window.__DB_TRIPS
    : STATIC_TRIPS;

// ================================================================
//  Budget mapping: survey answer → budget tier
// ================================================================
const BUDGET_MAP = {
    low:    ['low'],
    medium: ['low', 'medium'],
    high:   ['medium', 'high'],
    luxury: ['high', 'luxury'],
};

// Duration mapping: survey answer → max days
const DURATION_MAP = {
    weekend:  3,
    week:     7,
    twoweeks: 14,
    month:    35,
};

// ================================================================
//  matchTrips: filter and rank trips based on survey answers
// ================================================================
export function matchTrips(answers) {
    const allowedBudgets = BUDGET_MAP[answers.budget] || Object.keys(BUDGET_MAP).flatMap(k => BUDGET_MAP[k]);
    const maxDays = DURATION_MAP[answers.duration] || 35;

    const scored = TRIPS_DATA.map(trip => {
        let score = 0;

        if (allowedBudgets.includes(trip.budget_tier)) score += 3;
        if (trip.travel_type.includes(answers.travel_type)) score += 3;
        if (trip.climate === answers.climate) score += 2;
        if (trip.duration <= maxDays) score += 1;
        if (trip.duration <= maxDays + 2) score += 0.5; // slight tolerance

        return { ...trip, score };
    });

    const matched = scored
        .filter(t => t.score >= 4) // at least budget + type match
        .sort((a, b) => b.score - a.score);

    // If fewer than 3 matches, fill with best general recommendations
    if (matched.length < 3) {
        const fallback = scored
            .filter(t => !matched.find(m => m.id === t.id))
            .sort((a, b) => b.score - a.score)
            .slice(0, 3 - matched.length);
        return [...matched, ...fallback];
    }

    return matched.slice(0, 9); // max 9 results
}

// ================================================================
//  renderTripCards: build HTML for a list of trips
// ================================================================
export function renderTripCards(trips, lang = 'ar', container = null) {
    const html = trips.map(trip => {
        const title     = lang === 'ar' ? trip.title_ar     : trip.title_en;
        const country   = lang === 'ar' ? trip.country_ar   : trip.country_en;
        const desc      = lang === 'ar' ? trip.desc_ar      : trip.desc_en;
        const duration  = lang === 'ar' ? `${trip.duration} أيام` : `${trip.duration} days`;
        const priceLabel = lang === 'ar' ? `يبدأ من ${trip.currency}${trip.price}` : `From ${trip.currency}${trip.price}`;
        const bookLabel  = lang === 'ar' ? 'التفاصيل' : 'Details';
        const waMsg = encodeURIComponent(
            lang === 'ar'
                ? `مرحباً، أريد الاستفسار عن رحلة: ${title}`
                : `Hello, I want to inquire about: ${title}`
        );

        const detailUrl  = `/trips/${trip.id}`;
        const bookUrl    = `/trips/${trip.id}/book`;
        const spotsLeft  = trip.spots_left ?? 10;
        const spotsTotal = trip.spots_total ?? 20;
        const spotsUrgent = spotsLeft <= 3;
        const spotsColor  = spotsUrgent ? '#C0392B' : spotsLeft <= 7 ? '#E67E22' : '#1A936F';
        const spotsLabel  = lang === 'ar'
            ? `${spotsLeft} مقعد متاح`
            : `${spotsLeft} seats left`;

        const thumbStyle = trip.image
            ? `background-image:url('${trip.image}'); background-size:cover; background-position:center;`
            : `background:linear-gradient(135deg,${trip.color_from},${trip.color_to});`;

        return `
        <div class="trip-card fade-up" data-category="${trip.category}" data-id="${trip.id}" style="cursor:pointer;" onclick="window.location='${detailUrl}'">
            <div class="trip-card-thumb" style="${thumbStyle}">
                <div class="trip-card-overlay"></div>
                <span class="trip-card-price" data-price-usd="${trip.price}">${trip.currency}${trip.price}</span>
            </div>
            <div class="trip-card-body">
                <h3 class="trip-card-title">${title}</h3>
                <div class="trip-card-meta">
                    <span><i class="fa-solid fa-location-dot fa-xs" style="color:#C5A028;"></i> ${country}</span>
                    <span><i class="fa-regular fa-clock fa-xs" style="color:#C5A028;"></i> ${duration}</span>
                </div>
                <p style="color:#555; font-size:0.85rem; margin-top:0.5rem; line-height:1.6;">
                    ${desc.length > 80 ? desc.substring(0, 80) + '...' : desc}
                </p>
                <div style="display:flex; align-items:center; gap:0.4rem; margin-top:0.6rem;">
                    <i class="fa-solid fa-user-group fa-xs" style="color:${spotsColor};"></i>
                    <span style="font-size:0.78rem; font-weight:700; color:${spotsColor};">${spotsLabel}</span>
                    ${spotsUrgent ? `<span style="font-size:0.7rem; background:${spotsColor}; color:white; padding:0.1rem 0.4rem; border-radius:10px; font-weight:700;">${lang==='ar'?'آخر مقاعد!':'Last seats!'}</span>` : ''}
                </div>
                <div style="margin-top:0.4rem; height:4px; background:#f0f0f0; border-radius:4px; overflow:hidden;">
                    <div style="height:100%; width:${Math.round((spotsLeft/spotsTotal)*100)}%; background:${spotsColor}; border-radius:4px; transition:width 0.5s;"></div>
                </div>
            </div>
            <div class="trip-card-footer">
                <span style="color:#C5A028; font-weight:700; font-size:0.9rem;">${lang==='ar'?'يبدأ من ':' From '}<span data-price-usd="${trip.price}">${trip.currency}${trip.price}</span></span>
                <div style="display:flex; gap:0.4rem;" onclick="event.stopPropagation()">
                    <a href="${detailUrl}"
                       style="background:#f0f4f8; color:#1A3A5C; font-weight:700; font-size:0.78rem; padding:0.35rem 0.75rem; border-radius:20px; text-decoration:none; transition:all 0.2s; display:flex; align-items:center; gap:0.3rem;"
                       onmouseover="this.style.background='#e2e8f0'"
                       onmouseout="this.style.background='#f0f4f8'"
                    ><i class="fa-solid fa-circle-info fa-xs"></i> ${bookLabel}</a>
                    <a href="${bookUrl}"
                       style="background:linear-gradient(135deg,#C5A028,#F0D060); color:#1A1A1A; font-weight:700; font-size:0.78rem; padding:0.35rem 0.75rem; border-radius:20px; text-decoration:none; transition:all 0.2s; display:flex; align-items:center; gap:0.3rem;"
                       onmouseover="this.style.transform='scale(1.05)'"
                       onmouseout="this.style.transform='scale(1)'"
                    ><i class="fa-solid fa-calendar-check fa-xs"></i> ${lang==='ar'?'احجز':'Book'}</a>
                </div>
            </div>
        </div>`;
    }).join('');

    if (container) {
        container.innerHTML = html;
        // Re-observe newly added fade-up elements
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        container.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
        // Apply active currency conversion if widget is loaded
        if (typeof window.__convertAllPrices === 'function') {
            window.__convertAllPrices();
        }
    }

    return html;
}

// ================================================================
//  filterByCategory: helper used in home page tabs
// ================================================================
export function filterByCategory(category) {
    if (category === 'all') return TRIPS_DATA;
    return TRIPS_DATA.filter(t => t.category === category);
}
