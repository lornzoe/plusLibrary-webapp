import React from 'react';
import SecondaryButton from '@/Components/SecondaryButton';

export default function SteamGame({ steamgame }) {
    return (
        <>
            <div className="grid grid-rows-3 grid-flow-col p-2 h-96 mx-auto 2xl:mr-2 2xl:ml-2 gap-0 pt-0 pb-6">
                <div className="col-span-2 relative border ml-4 p-4 place-items-top m-auto mr-0 rounded-t flex-initial">
                    <div className="text-4xl text-gray-800 font-black">{steamgame.name}</div>
                    <div className="flex-grow border border-gray-400 margin-auto"></div>
                    <div className="absolute origin-top-right top-0 right-0 m-2">
                        <SecondaryButton><small>{steamgame.appid}  {!steamgame.owned && '- NOT OWNED'}</small></SecondaryButton>
                    </div>   
                </div>
                <div className="row-span-2 col-span-2 border grid grid-rows-4 grid-flow-col gap-2 p-4 ml-4 ml-1 rounded-b">
                    <div className="row-span-3 border grid grid-rows-3 grid-cols-2 w-60">
                        <div className="p-3 place-items-center flex">
                            <p>playtime</p>
                        </div>
                        <div className="m-auto ml-0 pl-1 text-left pt-1 ">
                            <p className="block">{(steamgame.playtime / 60).toFixed(2)} hours</p>
                            <small className="block text-sm text-gray-400 ">({steamgame.playtime} mins)</small>
                        </div> 
                        <div className="p-3 place-items-center flex">
                            <p className="">2weeks</p>
                            </div>
                        <div className="m-auto ml-0 pl-1 text-left">
                            <p className="block">{(steamgame.playtime_2weeks / 60).toFixed(2)} hours</p>
                            <small className="block text-sm text-gray-400">({steamgame.playtime_2weeks} mins)</small>
                        </div>
                        <div className="p-3 place-items-center flex">
                            <p>$/hrs</p>
                        </div>
                        <div className="m-auto ml-0 pl-1 text-left">
                            $ {((steamgame.fillables.cost_initial + steamgame.fillables.cost_additional)/steamgame.playtime * 60).toFixed(2)}                              
                        </div>
                    </div>
                    <div className="border grid grid-rows-1 grid-cols-2 w-60">
                        <div className="p-2 place-items-center flex">
                            achievements
                        </div>
                        <div className="place-items-center flex p-0">
                        {steamgame.achievements_total == 0 ? 
                        <div className="flex-grow border-top border-1 border-gray-400 margin-auto pr-1"><hr/></div> 
                        :   <>
                            <span className='block text-sm text-gray-800'>{steamgame.achievements_achieved} / {steamgame.achievements_total}</span>
                            <small className="block text-sm text-gray-400">&nbsp;({(steamgame.achievements_achieved/steamgame.achievements_total * 100).toFixed(2)} %)</small>
                            </>
                        }
                        </div>
                    </div>

                    <div className="row-span-3 grid grid-rows-3 grid-cols-2 border w-60">
                        <div className="p-3 place-items-center flex">cost</div>
                        <div className="m-auto ml-0 pl-1 text-left">
                            $ {(steamgame.fillables.cost_initial + steamgame.fillables.cost_additional).toFixed(2)} 
                        </div> 
                        <div className="p-2 place-items-center flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-4 h-4">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M4.5 4.5l15 15m0 0V8.25m0 11.25H8.25" />
                            </svg>
                            <p className="pl-1">init cost</p>
                        </div>
                        <div className="m-auto ml-0 pl-1 text-left">
                            
                            $ {(steamgame.fillables.cost_initial === null ? "0.00" : steamgame.fillables.cost_initial.toFixed(2))} 
                        </div>
                        <div className="p-2 place-items-center flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-4 h-4 ">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M4.5 4.5l15 15m0 0V8.25m0 11.25H8.25" />
                            </svg> 
                            <p className="pl-1">dlc / mtx</p>
                        </div>
                        <div className="m-auto ml-0 pl-1 text-left">
                            $ {(steamgame.fillables.cost_additional === null ? "0.00" : steamgame.fillables.cost_additional .toFixed(2))} 
                        </div>
                    </div>
                    <div className="text-gray-800 border grid grid-rows-1 grid-cols-2 w-60">
                        <div className="p-2 place-items-center flex">
                        obtained date
                        </div>
                        <div className="text-left place-items-center flex">
                        {steamgame.fillables.date_obtained !== null ? steamgame.fillables.date_obtained : "DD/MM/YYYY"}
                        </div>
                    </div>

                    <div className="row-span-4 grid grid-rows-4 grid-flow-col gap-0 flex-initial  2xl:w-[40rem]">
                        <div className="row-span-3 border flex justify-center items-center bg-yellow-100 flex-1 w-32">
                            <p className="text-3xl font-black text-center">{steamgame.fillables.rating === null ? "-" : steamgame.fillables.rating}</p>
                        </div>
                        <div className="p-2 pt-2 mt-2  bg-slate-400/[0.3] border w-32">
                            <p className="text-center text--base">{!steamgame.fillables.completed && "not "} completed</p>
                        </div>

                        <div className="row-span-4 p-4 border flex  overflow-auto w-[18.625rem] 2xl:w-[31.25rem]">
                            <p className="text-center my-auto">{steamgame.fillables.thoughts}</p>
                        </div>
                    </div>
                </div>
                <div className="row-span-3 place-items-center h-full order-first pt-6">
                    <img className="rounded object-cover h-full mx-auto" src={`https://cdn.cloudflare.steamstatic.com/steam/apps/${steamgame.appid}/library_600x900.jpg`}/>
                </div>
            </div>
        </>
    );
}