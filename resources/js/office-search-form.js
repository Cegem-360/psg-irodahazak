// Office search form (components/office-search-form.blade.php): district picker with map,
// office-name picker and the two range sliders. Initialised on every
// "livewire:navigated" (which also fires on the first page load), so it works
// with wire:navigate page changes; each form is wired up only once.

let selectedDistricts = [];
let config = { offices: [], i18n: {} };

const byId = (id) => document.getElementById(id);

const escapeHtml = (value) =>
    String(value).replace(/[&<>"']/g, (char) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" })[char]);

function readConfig() {
    const element = byId("office-search-form-config");
    config = element ? JSON.parse(element.textContent) : { offices: [], i18n: {} };
}

function initSliders() {
    $(".terulet-slider").ionRangeSlider({
        type: "double",
        min: 0,
        max: 3000,
        from: 0,
        to: 3000,
        grid: true,
        skin: "round",
        postfix: "&nbsp;m2",
        onFinish(data) {
            byId("areaMin").value = data.from;
            byId("areaMax").value = data.to;
        },
    });

    $(".ar-slider").ionRangeSlider({
        type: "double",
        min: 1,
        max: 30,
        from: 1,
        to: 30,
        grid: true,
        skin: "round",
        postfix: "&nbsp;€/m2",
        onFinish(data) {
            byId("priceMin").value = data.from;
            byId("priceMax").value = data.to;
        },
    });
}

function syncDistricts() {
    byId("selectedDistricts").value = selectedDistricts.join(",");
    updateDropdownSelections();
    updateSelectedDistrictsDisplay();
    updateMapHighlights();
}

// Called from the onclick handlers of the district map (components/svg/bp-map).
function selectDistrict(districtName, event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }

    const district = String(districtName);
    const index = selectedDistricts.indexOf(district);

    if (index > -1) {
        selectedDistricts.splice(index, 1);
    } else {
        selectedDistricts.push(district);
    }

    syncDistricts();

    return false;
}

window.selectDistrict = selectDistrict;

function initializeSelectedDistricts() {
    const districtsParam = new URLSearchParams(window.location.search).get("districts");
    selectedDistricts = districtsParam ? districtsParam.split(",").filter((d) => d.trim() !== "") : [];

    if (selectedDistricts.length > 0) {
        syncDistricts();
    }
}

function updateDropdownSelections() {
    document.querySelectorAll(".district-checkbox").forEach((checkbox) => {
        checkbox.checked = selectedDistricts.includes(checkbox.value);
    });
    updateDropdownText();
}

function updateDropdownText() {
    const dropdownText = byId("dropdownText");

    if (selectedDistricts.length === 0) {
        dropdownText.textContent = config.i18n.selectDistricts;
    } else if (selectedDistricts.length === 1) {
        dropdownText.textContent = selectedDistricts[0];
    } else {
        dropdownText.textContent = config.i18n.districtsSelected.replace(":count", selectedDistricts.length);
    }
}

function updateSelectedDistrictsDisplay() {
    const display = byId("selectedDistrictsDisplay");

    if (selectedDistricts.length > 0) {
        display.classList.remove("hidden");
        byId("districtsNames").textContent = selectedDistricts.join(", ");
    } else {
        display.classList.add("hidden");
    }
}

function updateMapHighlights() {
    clearMapHighlights();

    selectedDistricts.forEach((district) => {
        const districtLink = document.querySelector(`svg a[onclick*="selectDistrict('${district}',"]`);
        districtLink?.classList.add("selected-district");
    });
}

function clearMapHighlights() {
    document.querySelectorAll("svg a.selected-district").forEach((link) => link.classList.remove("selected-district"));
}

function toggleMenu(menu, arrow, open) {
    menu.classList.toggle("hidden", !open);
    arrow.style.transform = open ? "rotate(180deg)" : "rotate(0deg)";
}

function initDistrictDropdown() {
    const dropdownButton = byId("dropdownButton");
    const dropdownMenu = byId("dropdownMenu");
    const dropdownArrow = byId("dropdownArrow");

    dropdownButton.addEventListener("click", (event) => {
        event.preventDefault();
        toggleMenu(dropdownMenu, dropdownArrow, dropdownMenu.classList.contains("hidden"));
    });

    document.querySelectorAll(".district-checkbox").forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            if (this.checked) {
                if (!selectedDistricts.includes(this.value)) {
                    selectedDistricts.push(this.value);
                }
            } else {
                selectedDistricts = selectedDistricts.filter((district) => district !== this.value);
            }

            byId("selectedDistricts").value = selectedDistricts.join(",");
            updateDropdownText();
            updateMapHighlights();
            updateSelectedDistrictsDisplay();
        });
    });

    byId("clearSelections").addEventListener("click", () => {
        selectedDistricts = [];
        byId("selectedDistricts").value = "";
        updateDropdownSelections();
        updateSelectedDistrictsDisplay();
        clearMapHighlights();
    });
}

function initOfficeDropdown() {
    const officeDropdownButton = byId("officeDropdownButton");
    const officeDropdownMenu = byId("officeDropdownMenu");
    const officeDropdownArrow = byId("officeDropdownArrow");
    const officeSearchInput = byId("officeSearchInput");
    let officeSearchTimeout;

    const currentOfficeValue = byId("selectedOfficeName").value;
    if (currentOfficeValue) {
        byId("officeDropdownText").textContent = currentOfficeValue;
    }

    officeDropdownButton.addEventListener("click", (event) => {
        event.preventDefault();
        const open = officeDropdownMenu.classList.contains("hidden");
        toggleMenu(officeDropdownMenu, officeDropdownArrow, open);

        if (open) {
            officeSearchInput.focus();
            loadOfficeNames("");
        }
    });

    officeSearchInput.addEventListener("input", function () {
        clearTimeout(officeSearchTimeout);
        officeSearchTimeout = setTimeout(() => loadOfficeNames(this.value.trim()), 300);
    });
}

function loadOfficeNames(searchTerm) {
    const officeLoading = byId("officeLoading");
    const officeEmpty = byId("officeEmpty");
    const officeResults = byId("officeResults");
    const allOption = `<div class="px-3 py-2 hover:bg-gray-50 rounded cursor-pointer office-option" data-value=""><div class="text-gray-500 italic">${escapeHtml(config.i18n.allOfficeBuildings)}</div></div>`;

    officeLoading.classList.remove("hidden");
    officeEmpty.classList.add("hidden");

    const filteredOffices = config.offices.filter((office) => office.title.toLowerCase().includes(searchTerm.toLowerCase()));

    setTimeout(() => {
        officeLoading.classList.add("hidden");

        if (filteredOffices.length === 0 && searchTerm) {
            officeEmpty.classList.remove("hidden");
            officeResults.innerHTML = allOption;
        } else {
            officeEmpty.classList.add("hidden");
            officeResults.innerHTML =
                allOption +
                filteredOffices
                    .map(
                        (office) => `
                <div class="px-3 py-2 hover:bg-gray-50 rounded cursor-pointer office-option" data-value="${escapeHtml(office.title)}">
                    <div class="font-medium">${escapeHtml(office.title)}</div>
                    <div class="text-sm text-gray-500">${escapeHtml(office.city)}</div>
                </div>`,
                    )
                    .join("");
        }

        officeResults.querySelectorAll(".office-option").forEach((option) => {
            option.addEventListener("click", () => selectOffice(option.dataset.value));
        });
    }, 200);
}

function selectOffice(officeName) {
    byId("selectedOfficeName").value = officeName;
    byId("officeDropdownText").textContent = officeName || config.i18n.officeBuildingName;
    toggleMenu(byId("officeDropdownMenu"), byId("officeDropdownArrow"), false);
}

// Close the dropdowns on an outside click. Registered once for the whole document,
// so it keeps working across wire:navigate page changes without piling up.
document.addEventListener("click", (event) => {
    for (const [buttonId, menuId, arrowId] of [
        ["dropdownButton", "dropdownMenu", "dropdownArrow"],
        ["officeDropdownButton", "officeDropdownMenu", "officeDropdownArrow"],
    ]) {
        const button = byId(buttonId);
        const menu = byId(menuId);

        if (button && menu && !button.contains(event.target) && !menu.contains(event.target)) {
            toggleMenu(menu, byId(arrowId), false);
        }
    }
});

document.addEventListener("livewire:navigated", () => {
    const form = byId("filterForm");

    if (!form || form.dataset.initialized) {
        return;
    }

    form.dataset.initialized = "true";
    readConfig();
    initSliders();
    initDistrictDropdown();
    initOfficeDropdown();
    initializeSelectedDistricts();
});
