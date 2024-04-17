import {useState, React} from 'react';
import * as Dialog from '@radix-ui/react-dialog';
import * as Checkbox from '@radix-ui/react-checkbox';
import { CheckIcon, XMarkIcon} from '@heroicons/react/20/solid';
import clsx from 'clsx';
import dayjs from 'dayjs';
import { useForm } from '@inertiajs/inertia-react';

export default function PurchaseRecordForm({record}) {

  const [open, setOpen] = useState(false);
  const [checked, setChecked] = useState(record.is_initial? record.is_initial : false);
  const [formData, setFormData] = useState({
    recordid : record.recordid ? record.recordid : "",
    appid : record.appid,
    date : record.date ? record.date : dayjs().format('YYYY-MM-DD'), //
    desc : record.desc ? record.desc : "",
    cost : record.cost ? record.cost : "",
    is_initial : record.is_initial ? record.is_initial : false
  });
  
  const toggleChecked = () =>
  {
    setChecked(!checked)
    setFormData({...formData, is_initial: !checked});
  }

  const handleChange = (event) => {
    
    if(event.target.name === "date"){
    setFormData({...formData, [event.target.name]: 
    dayjs(event.target.value).format('YYYY-MM-DD')});
    }
    else{
      setFormData({...formData, [event.target.name]: event.target.value})
    }
    
    console.log(formData);
  }

  const handleSubmit = (event) => {
    event.preventDefault();

    console.log ("submit:");
    console.log(formData);

    if (formData.recordid === "") // if we're using the create
    {
      setFormData({...formData, date: dayjs().format('YYYY-MM-DD'), cost: "", desc: "", is_initial: false});
      setChecked(false);
    }

    setOpen(false);
    
  }

  return (
    <>
      <div>
        <Dialog.Root open={open} onOpenChange={setOpen}>
          <Dialog.Trigger >
            {formData.recordid ==="" ?
            <div className="bg-white p-2 border justify-center rounded-lg">Add New</div> :
            <div className={clsx("bg-white  border justify-center rounded-lg",
            "px-5 py-2",
            "bg-white border justify-center rounded-lg")}>edit</div>
            }
          </Dialog.Trigger>

          <Dialog.Portal>
            <Dialog.Overlay forceMount className="fixed inset-0 z-20 bg-black/50" />
            <Dialog.Content className="fixed z-50 w-[95vw] max-w-md rounded-lg p-4 md:w-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white dark:bg-gray-800">
              <Dialog.Title className='text-xl'>creating/editing</Dialog.Title>
              <Dialog.Description className={clsx("mt-1 text-sm font-normal text-gray-700 dark:text-gray-400",
)}>
                create/edit PurchaseRecord with this dialog.
              </Dialog.Description>
              <form className="mt-2" onSubmit={handleSubmit}>

                <fieldset className=''>
                  <div className='grid grid-cols-2 content-between gap-4'>
                    <div className=''>
                      <label
                        htmlFor="recordid"
                        className="text-xs font-medium text-gray-700 dark:text-gray-400"
                      >
                        Record ID
                      </label>
                      <input name="recordid" type="text" placeholder='auto-generated if blank'
                        className='text-sm text-gray-500 block w-full rounded-md py-1 bg-gray-100' disabled={true} defaultValue={formData.recordid} readOnly/>
                    </div>
                    <div>
                      <label
                        htmlFor="appid"
                        className="text-xs font-medium text-gray-700 dark:text-gray-400"
                      >
                        App ID
                      </label>
                      <input name="appid" type="text" placeholder={formData.appid}
                        className='text-sm text-gray-500 block w-full rounded-md py-1 bg-gray-100' disabled={true} readOnly/>
                    </div>
                  </div>
                  <div className='grid grid-cols-2 content-between gap-4'>
                    <div className='mt-2'>
                      <label
                        htmlFor="date"
                        className="text-xs font-medium text-gray-700 dark:text-gray-400"
                      >
                        Date of Record
                      </label>
                      <input name="date" type="date"
                        className='text-sm block w-full rounded-md py-1' 
                        defaultValue={formData.date} 
                        onChange={handleChange}></input>
                    </div>
                  </div>
                  <div>
                    <label
                      htmlFor="desc"
                      className="text-xs font-medium text-gray-700 dark:text-gray-400"
                    >
                      Description
                    </label>
                    <input name="desc" type="text" placeholder='desc'
                      value={formData.desc ? formData.desc : ''}
                      onChange={handleChange}
                      className='text-sm block w-full rounded-md py-1'></input>
                  </div>
                  <div className='grid grid-cols-2 content-between gap-4'>
                    <div className=''>
                      <label
                        htmlFor="cost"
                        className="text-xs font-small text-gray-700 dark:text-gray-400"
                      >
                        Cost
                      </label>
                      <input name="cost" type="number" step="0.01" placeholder='$0.00'
                        value={formData.cost ? formData.cost : ''}
                        onChange={handleChange}
                        className='text-sm block w-full rounded-md py-1'></input>
                    </div>
                    <div className=''>
                      <label
                        htmlFor="check"
                        className="text-xs font-small text-gray-700 dark:text-gray-400"
                      >
                        Initial Purchase?
                      </label>
                      <div className='flex mt-0.5'>
                        <Checkbox.Root className='bg-white w-7 h-7 border rounded-lg border-gray-600' checked={checked} onCheckedChange={toggleChecked}>
                          <Checkbox.Indicator>
                            <CheckIcon className=' h-4 w-4 mx-auto fill-gray-600' />
                          </Checkbox.Indicator>
                        </Checkbox.Root>
                      </div>
                    </div>
                  </div>
                </fieldset>
              <Dialog.Close className='float-right float-top absolute top-3.5 right-3.5'>
                <XMarkIcon className='h-4 w-4 mx-auto'/>
              </Dialog.Close>

              <div className='pt-4'>
           
                <button type='submit' className={clsx("inline-flex select-none justify-center",
                "rounded-lg p-2 text-sm font-medium",
                "border rounded-lg w-full bg-gray-600",
                "text-white font-semibold")}
                >
                  Save</button>
              </div>  
              </form>
            </Dialog.Content>
          </Dialog.Portal>
        </Dialog.Root>
      </div>
    </>
  )
}