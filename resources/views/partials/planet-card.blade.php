<div class="planet-card card-gold">

    <!-- HEADER -->
    <div class="planet-header" @click="toggle(index)">
        <h3>@{{ planet.name }}</h3>
        <span class="chevron">@{{ activeIndex === index ? '▲' : '▼' }}</span>
    </div>

    <!-- PROPERTIES (ALWAYS VISIBLE) -->
    <div class="planet-properties-card">
        <div><strong>Climate:</strong> @{{ planet.climate }}</div>
        <div><strong>Terrain:</strong> @{{ planet.terrain }}</div>
        <div><strong>Population:</strong> @{{ planet.population }}</div>
        <div><strong>Gravity:</strong> @{{ planet.gravity }}</div>
    </div>

    <!-- EXPANDED CONTENT -->
    <transition name="accordion">
        <div v-if="activeIndex === index" class="planet-body">

        <div class="planet-split">

            <!-- FILMS -->
            <div class="split-column">
                <h4>Films</h4>

                <div
                    v-for="film in planet.films"
                    :key="film.id"
                    class="entity-card"
                >
                    <strong>@{{ film.title }}</strong>

                    <div class="tabs">
                        <button @click="setTab(film,'vehicles')">Vehicles</button>
                        <button @click="setTab(film,'species')">Species</button>
                        <button @click="setTab(film,'starships')">Starships</button>
                    </div>

                    <ul>
                        <li
                            v-for="item in film[film.activeTab]"
                            :key="item.id"
                            class="clickable"
                            @click="openModal(item)"
                        >
                            @{{ item.name }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- PEOPLE -->
            <div class="split-column">
                <h4>Residents</h4>

                <div
                    v-for="person in planet.people"
                    :key="person.id"
                    class="entity-card"
                >
                    <strong>@{{ person.name }}</strong>

                    <div class="tabs">
                        <button @click="setTab(person,'vehicles')">Vehicles</button>
                        <button @click="setTab(person,'species')">Species</button>
                        <button @click="setTab(person,'starships')">Starships</button>
                    </div>

                    <ul>
                        <li
                            v-for="item in person[person.activeTab]"
                            :key="item.id"
                            class="clickable"
                            @click="openModal(item)"
                        >
                            @{{ item.name }}
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    </transition>
</div>
