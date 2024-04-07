import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/inertia-react';
import SteamGame_overview from '@/Components/SteamGame_overview';
import SteamGame_expanded from '@/Components/SteamGame_expanded';
import Test from '@/Components/Test';


export default function Index({auth, game}) {

    // console.log(game);

    return (
        <AuthenticatedLayout
            auth={auth}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">{game.name}</h2>}
        >
            <Head title="GameView" />

            <div className="flex-initial w-2xl mx-auto pl-0 pr-0 p-2 lg:p-2 xl:p-8 max-w-screen-2xl">
                <div className="mt-6 bg-white shadow-sm lg:rounded-lg divide-y p-2">
                    <div className="m-6 bg-white overflow-hidden shadow-lg sm:rounded-lg">
                        <SteamGame_overview key={game.appid} steamgame={game}/>
                    </div>
                    <div className="m-6 bg-white overflow-hidden shadow-lg sm:rounded-lg">
                        <SteamGame_expanded key={game.appid} steamgame={game}/>
                    </div>
                        <div className="float-left m-6 bg-white overflow-hidden shadow-lg sm:rounded-lg">
                        <Test/></div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
