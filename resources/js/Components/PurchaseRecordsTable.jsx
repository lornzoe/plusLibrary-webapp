import React, { useState, useEffect } from 'react';
import * as Checkbox from '@radix-ui/react-checkbox';
import { CheckIcon } from '@heroicons/react/20/solid';

export default function PurchaseRecordsTable ({ purchaserecords }) {

    console.log(purchaserecords);

    return (
        <>
        <table className="border border-separate w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" className='px-6 py-3 rounded-tl-lg '>id</th>
                    <th scope="col" className='px-6 py-3'>Date of Purchase</th>
                    <th scope="col" className='px-6 py-3'>Description</th>
                    <th scope="col" className='px-6 py-3'>Cost</th>
                    <th scope="col" className='px-6 py-3'>Initial Purchase?</th>
                    <th scope="col" className='px-6 py-3'>edit</th>
                </tr>
            </thead>
            <tbody>
                {purchaserecords?.map(
                    (purchase)=>
                    <tr key={purchase.id} className="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td className='px-6 py-3 whitespace-nowrap'>{purchase.id}</td>
                        <td className='px-6 py-3 whitespace-nowrap'>{purchase.date_of_purchase}</td>
                        <td className='px-6 py-3 '><p className='line-clamp-2'>{purchase.desc}</p></td>
                        <td className='px-6 py-3 whitespace-nowrap'>$ {purchase.cost}</td>
                        <td className='px-6 py-3'>
                            <Checkbox.Root className='bg-white w-6 h-6 border justify-center rounded-lg ' disabled defaultChecked={purchase.is_initial}>
                                <Checkbox.Indicator>
                                    <CheckIcon className=' h-4 w-4 mx-auto'/>
                                </Checkbox.Indicator>
                            </Checkbox.Root>
                        </td>
                        <td className='px-6 py-3'></td>
                    </tr>
                )}
            </tbody>
        </table>
        </>
    )
}