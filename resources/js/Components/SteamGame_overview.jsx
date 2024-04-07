import React from 'react';

export default function SteamGame_overview({ steamgame }) 
{
    return(
        <>
        <div className='py-1'>
            <div className='float-left px-1 my-auto'>
            <img className='rounded' src={`https://cdn.cloudflare.steamstatic.com/steam//apps/${steamgame.appid}/capsule_231x87.jpg`}/>
            </div>

            <div className='px-2 text-xl font-black max-w-xs text-ellipsis overflow-hidden'>{steamgame.name}</div>

            <div className='px-2 flex'>
                <div className='shrink-0'>
                    <div className='text-sm text-gray-400'>playtime:&nbsp;
                        <span className='text-xs'>
                        {(steamgame.playtime / 60).toFixed(2)} hrs
                        </span>
                    </div>
                    <div className='text-sm text-gray-400'>2weeks:&nbsp;
                        <span className='text-xs'>
                            {(steamgame.playtime_2weeks / 60).toFixed(2)} hrs
                        </span>
                    </div>
                    <div className='text-sm text-gray-400'>$/hr:&nbsp;
                        <span className='text-xs'>
                            ${((parseFloat(steamgame.fillables.cost_initial) + parseFloat(steamgame.fillables.cost_additional ? steamgame.fillables.cost_additional : 0.00))/steamgame.playtime * 60).toFixed(2) }     
                        </span>
                    </div>
                    
                </div>

                <div className='border-l border-gray-400 mx-2 my-2'></div>

                <div className='shrink-0'>
                    <div className='text-sm text-gray-400'>ach:&nbsp;{steamgame.achievements_total == 0 ? '-' : 
                            <>
                                <span className='text-xs'>
                                    {steamgame.achievements_achieved} / {steamgame.achievements_total}&nbsp;
                                    
                                    <span className={steamgame.achievements_achieved ? steamgame.achievements_total : `bg-yellow-400 rounded-full mx-1 px-1.5 py-auto text-stone-600`}>
                                        ({(steamgame.achievements_achieved/steamgame.achievements_total * 100).toFixed(2)} %)
                                    </span>
                                </span>
                            </>
                        }
                    </div>
                    <div className='text-sm text-gray-400'>obt date:&nbsp;
                        <span className='text-xs'>
                        {
                            steamgame.fillables.date_obtained !== null ? steamgame.fillables.date_obtained : "-"
                        }
                        </span>
                    </div>
                    <div className='text-sm text-gray-400'>
                        status:&nbsp;
                        <div className={`inline text-xs ${(steamgame.fillables.completed && `mx-1 px-2 py-auto bg-green-300 rounded-full`)}`}>
                            {steamgame.fillables.completed ? "✅" : "not completed"}
                        </div>                   
                    </div>
                </div>

                <div className='border-l border-gray-400 mx-2 my-2'></div>

                <div className='overflow-hidden' >
                    <div className={`inline-block whitespace-nowrap text-xs ${steamgame.fillables.rating && `text-stone-600 px-2 py-auto mt-[-9] rounded-full`}
                            ${steamgame.fillables.rating == 1 && `bg-red-400`}
                            ${steamgame.fillables.rating == 2 && `bg-orange-300`}
                            ${steamgame.fillables.rating == 3 && `bg-lime-300`}
                            ${steamgame.fillables.rating == 4 && `bg-green-300`}
                            ${steamgame.fillables.rating == 5 && `bg-yellow-300`}                                         
                            }`}>
                            {steamgame.fillables.rating}{steamgame.fillables.rating?` / 5`:`no rating`}
                    </div>
                    <div className='text-xs leading-none text-ellipsis grow-0 line-clamp-2 max-w-md'>
                        {steamgame.fillables.thoughts}{!steamgame.fillables.thoughts && `no written thoughts`}
                    </div>
                </div>            
            </div>

            

        </div>
        </>
    );
}