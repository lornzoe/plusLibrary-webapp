import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/inertia-react';
import SteamGame_overview from '@/Components/SteamGame_overview';

export default function Index({auth, game}) {

    console.log(game);

    return (
        <AuthenticatedLayout
            auth={auth}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">{game.name}</h2>}
        >
            <Head title="GameView" />

            <div className="flex-auto w-2xl mx-auto pl-0 pr-0 p-2 lg:p-2 xl:p-8">
                <div className="mt-6 bg-white shadow-sm lg:rounded-lg divide-y p-2">
                    <div className="m-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">new</div>
                    </div>
                    <div className="m-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">orig</div>
                    </div>
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <SteamGame_overview key={game.appid} steamgame={game}/>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
