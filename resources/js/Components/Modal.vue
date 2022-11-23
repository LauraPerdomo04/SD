<template>
    <teleport to="body">
      <!-- Modal -->
      <div class="modal fade" :id="id"  role="dialog" :aria-labelledby="id" aria-hidden="true">
          <div class="modal-dialog" role="document" :class="maxWidthClass">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">{{title}}</h5>
  
                      <button class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="$closeModal(id)">
                        <i class="fa fa-times" aria-hidden="true"></i>
                      </button>
                  </div>
                  <div class="modal-body">
                      <slot></slot>
                  </div>
              </div>
          </div>
      </div>
  
  
    </teleport>
  </template>
  <script>
    import { defineComponent } from 'vue'
    export default defineComponent({
      props: {
        id: {
          type: String,
          required: true
        },
        title: {
          type: String,
          required: false,
        },
        maxWidth: {
          default: 'md'
        }
      },
      components: {
  
      },
  
      computed: {
        maxWidthClass() {
          return {
            'sm': 'modal-sm',
            'md': null,
            'lg': 'modal-lg',
            'xl': 'modal-xl',
          }[this.maxWidth]
        }
      }
    })
  </script>
  <style>
  .modal-body{
      padding: 2rem;
  }
  .modal-header {
      display: flex;
      -ms-flex-align: start;
      align-items: flex-start;
      -ms-flex-pack: justify;
      justify-content: space-between;
      padding: 1rem;
      border-bottom: 1px solid #e9ecef;
      border-top-left-radius: calc(0.3rem - 1px);
      border-top-right-radius: calc(0.3rem - 1px);
      background: #003389;
      border-radius: 10px 10px 0px 0px;
      text-align: center;
      color: white;
      height: 40px;
      margin-top: 0px;
      padding: 3px;
  }
  .modal-title {
      margin-bottom: 0;
      line-height: 1.5;
      display: block;
      margin-left: 15px;
  }
  .btn-nygsoft-modal {
      padding: 0.7rem 1rem;
      height: 2.7rem;
      display: block;
      border: 0;
      border-radius: 10px;
      font-weight: 500;
      background: white;
      color: #003389;
      text-decoration: none;
      cursor: pointer;
      text-align: center;
      transition: all 0.5s;
      margin: -27px -17px 0px 0px;
  }
  .modal-content-NyGsoft
  {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    width: 100%;
    pointer-events: auto;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 15px;
    box-shadow: 0 0.25rem 0.5rem rgb(0 0 0 / 50%);
    outline: 0;
  }
  .btn-nygsoft-modal:hover
  {
    background-color: #266bbb;
    color: white;
  }
  </style>
  