import{d as a,o,a as i,E as s,b as c,n as l,W as f,c as d,h as m,j as p,X as g,u as b}from"./vendor.5936ec8c.js";const h={class:"mx-auto flex max-w-7xl items-start py-6 px-4 sm:px-6 lg:px-8"},w=a({props:{title:null},setup(e){return(t,r)=>(o(),i("div",h,[s(t.$slots,"aside"),c("main",{class:l(["min-h-full w-full",{"ml-8":t.$slots.aside}])},[s(t.$slots,"default")],2)]))}}),B=a({props:{color:{default:"default"},full:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1}},setup(e){const t=e,r=f(),n=d(()=>t.disabled?"button":r.href?"Link":"button");return(u,y)=>(o(),m(g(b(n)),{type:"button",class:l(["border-transparent flex items-center justify-center rounded-md border px-3 py-2 text-sm font-medium leading-4 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2",{"bg-white text-primary-600 hover:bg-primary-100 focus:ring-primary-500":e.color==="default","bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500":e.color==="primary","bg-white text-red-500 hover:bg-red-100 focus:ring-red-500":e.color==="danger","w-full":e.full}])},{default:p(()=>[s(u.$slots,"default")]),_:3},8,["class"]))}});export{w as _,B as a};
