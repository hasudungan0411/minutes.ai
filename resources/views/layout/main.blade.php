<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        .animated {
            -webkit-animation-duration: 1s;
            animation-duration: 1s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
        }

        .animated.faster {
            -webkit-animation-duration: 500ms;
            animation-duration: 500ms;
        }

        .fadeIn {
            -webkit-animation-name: fadeIn;
            animation-name: fadeIn;
        }

        .fadeOut {
            -webkit-animation-name: fadeOut;
            animation-name: fadeOut;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <div class="grid grid-cols-3 gap-4 h-screen">
        <div class="row-span-3 col-span-1 bg-slate-100 uppercase text-center font-bold italic text-3xl py-10">
            <h1>Notulain</h1>

            <ul class="mt-20 px-20">
                <li
                    class="mb-10 bg-white h-20 flex justify-center items-center rounded-sm hover:bg-slate-400 hover:text-white">
                    <a href="/">
                        <button>
                            Beranda
                        </button>
                    </a>
                </li>
                <li
                    class="bg-white h-20 flex justify-center items-center rounded-sm hover:bg-slate-400 hover:text-white">
                    <a href="/caraPenggunaan">
                        <button>
                            Cara Penggunaan
                        </button>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-span-2 h-20 flex justify-center items-center">
            <input type="text" placeholder="Search" class="border-2 border-black w-10/12 h-10 px-5 rounded-full">
        </div>
        <div class="col-span-2">
            @yield('content')
        </div>
    </div>


    <script>
        const modal = document.querySelector('.main-modal');
        const closeButton = document.querySelectorAll('.modal-close');

        const modalClose = () => {
            modal.classList.remove('fadeIn');
            modal.classList.add('fadeOut');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 500);
        }

        const openModal = () => {
            modal.classList.remove('fadeOut');
            modal.classList.add('fadeIn');
            modal.style.display = 'flex';
        }

        for (let i = 0; i < closeButton.length; i++) {

            const elements = closeButton[i];

            elements.onclick = (e) => modalClose();

            modal.style.display = 'none';

            window.onclick = function(event) {
                if (event.target == modal) modalClose();
            }
        }

        const dropdownButton = document.getElementById('dropdown-button');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const searchInput = document.getElementById('search-input');
        let isOpen = false;

        dropdownMenu.classList.add('hidden');

        function toggleDropdown() {
            isOpen = !isOpen;
            dropdownMenu.classList.toggle('hidden', !isOpen);
        }

        dropdownButton.addEventListener('click', () => {
            toggleDropdown();
        });

        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase();
            const items = dropdownMenu.querySelectorAll('a');

            items.forEach((item) => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>